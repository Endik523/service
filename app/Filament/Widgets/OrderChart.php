<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


class OrderChart extends ChartWidget
{
    protected static ?string $heading = 'Prediksi Pesanan';
    protected static ?string $description = 'Grafik data historis dan prediksi pesanan';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $contentHeight = 600;
    protected static ?string $maxHeight = null;

    public ?string $filter = '30';

    public static function canView(): bool
    {
        return Auth::user()?->role !== 'teknisi';
    }

    protected function getFilters(): ?array
    {
        return [
            '1' => 'Hari Ini',
            '7' => '7 Hari',
            '14' => '14 Hari',
            '30' => '30 Hari',
            '90' => '90 Hari',
        ];
    }

    protected function getData(): array
    {
        $jumlahHariPrediksi = intval($this->filter ?? 30);
        $startDate = '2023-04-01';
        $endDate = '2025-04-30';

        // Get historical data with optimized query
        $rawData = Order::query()
            ->whereBetween('tgl_pesan', [$startDate, $endDate])
            ->selectRaw('DATE(tgl_pesan) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Fill missing dates with interpolated values
        $historicalData = collect();
        $period = CarbonPeriod::create($startDate, $endDate);
        $previousValue = null;
        $nextValue = null;
        
        foreach ($period as $date) {
            $formatted = $date->format('Y-m-d');
            if (isset($rawData[$formatted])) {
                $historicalData->put($formatted, $rawData[$formatted]);
                $previousValue = $rawData[$formatted];
            } else {
                // Simple interpolation for missing values
                $interpolated = $previousValue ?? 0;
                $historicalData->put($formatted, $interpolated);
            }
        }

        // Remove leading zeros and ensure minimum data points
        $historicalData = $historicalData->filter(function($value, $key) {
            return $value > 0;
        });

        if ($historicalData->count() < 30) {
            throw new \Exception('Insufficient historical data for reliable prediction');
        }

        // Calculate enhanced statistics
        $values = $historicalData->values();
        $avgOrders = $values->avg();
        $maxOrders = $values->max();
        $minOrders = $values->min();
        $stdDev = sqrt($values->map(fn($x) => pow($x - $avgOrders, 2))->avg());
        
        // Calculate volatility and trend strength
        $volatility = $stdDev / $avgOrders;
        $recentTrend = $this->calculateTrend($values->slice(-30));
        
        // Conservative parameter adjustment for realistic predictions
        $alpha = min(0.4, max(0.1, 0.2 + $volatility * 0.3)); // More conservative smoothing
        $beta = min(0.3, max(0.05, 0.1 + abs($recentTrend) * 0.2)); // Reduced trend impact
        $gamma = min(0.3, max(0.05, 0.1 + $volatility * 0.2)); // Conservative seasonal
        $seasonLength = 7; // Weekly seasonality

        // Enhanced Holt-Winters initialization
        $level = $this->calculateInitialLevel($values, $seasonLength);
        $trend = $this->calculateInitialTrend($values, $seasonLength);
        $seasonal = $this->calculateInitialSeasonal($historicalData, $seasonLength, $avgOrders);

        // Advanced Triple Exponential Smoothing
        $forecastErrors = [];
        $adaptiveFactors = [];
        
        foreach ($historicalData as $date => $actual) {
            $dateObj = Carbon::parse($date);
            $seasonIndex = $dateObj->dayOfWeek;
            
            // Calculate forecast for error tracking
            $forecast = $level + $trend + $seasonal[$seasonIndex];
            $error = $actual - $forecast;
            $forecastErrors[] = $error;
            
            // Adaptive learning rate based on forecast accuracy
            $adaptiveFactor = 1.0;
            if (count($forecastErrors) >= 7) {
                $recentErrors = array_slice($forecastErrors, -7);
                $mape = array_sum(array_map(fn($e) => abs($e), $recentErrors)) / 7;
                $adaptiveFactor = min(1.5, max(0.5, 1.0 - ($mape / $avgOrders)));
            }
            $adaptiveFactors[] = $adaptiveFactor;
            
            // Update components with adaptive learning
            $lastLevel = $level;
            $level = ($alpha * $adaptiveFactor) * ($actual - $seasonal[$seasonIndex]) + 
                    (1 - $alpha * $adaptiveFactor) * ($level + $trend);
            
            $trend = ($beta * $adaptiveFactor) * ($level - $lastLevel) + 
                    (1 - $beta * $adaptiveFactor) * $trend;
            
            $seasonal[$seasonIndex] = ($gamma * $adaptiveFactor) * ($actual - $level) + 
                                    (1 - $gamma * $adaptiveFactor) * $seasonal[$seasonIndex];
        }

        // Generate sophisticated predictions
        $predictedData = collect();
        $lastDate = Carbon::parse($endDate);
        $confidenceIntervals = [];
        
        // Calculate prediction intervals
        $residuals = array_slice($forecastErrors, -min(50, count($forecastErrors)));
        $residualStdDev = sqrt(array_sum(array_map(fn($r) => $r * $r, $residuals)) / count($residuals));
        $noiseLevel = $residualStdDev;
        
        for ($i = 1; $i <= $jumlahHariPrediksi; $i++) {
            $nextDate = $lastDate->copy()->addDays($i);
            $seasonIndex = $nextDate->dayOfWeek;
            
            // Conservative base prediction with stronger damping
            $trendDamping = pow(0.95, $i); // Stronger damping for stability
            $basePrediction = $level + ($trend * $i * $trendDamping) + $seasonal[$seasonIndex];
            
            // Reduce cyclical component impact
            $cyclicalComponent = $this->calculateCyclicalComponent($i, $avgOrders) * 0.3; // Reduced impact
            
            // Apply mean reversion for long-term stability
            $meanReversionFactor = 1 - (0.02 * $i); // Gradual pull toward mean
            $prediction = ($basePrediction * $meanReversionFactor) + ($avgOrders * (1 - $meanReversionFactor));
            $prediction += $cyclicalComponent;
            
            // More conservative bounds
            $lowerBound = max(0, $minOrders * 0.5);
            $upperBound = min($maxOrders * 1.5, $avgOrders * 2); // Stricter upper bound
            $prediction = max($lowerBound, min($upperBound, $prediction));
            
            // Ensure realistic integer values
            $prediction = max(0, round($prediction));
            
            $predictedData->put($nextDate->format('Y-m-d'), $prediction);
            
            // Calculate confidence intervals
            $confidence = 1.96 * $noiseLevel; // 95% confidence interval
            $confidenceIntervals[$nextDate->format('Y-m-d')] = [
                'lower' => max($lowerBound, round($prediction - $confidence)),
                'upper' => min($upperBound, round($prediction + $confidence))
            ];
        }

        // Prepare enhanced chart data
        $labels = array_merge(
            array_keys($historicalData->toArray()),
            array_keys($predictedData->toArray())
        );

        return [
            'datasets' => [
                [
                    'label' => 'Data Historis',
                    'data' => $historicalData->values()->toArray(),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderWidth' => 2,
                    'tension' => 0.3,
                    'pointRadius' => 2,
                    'pointHoverRadius' => 4,
                    'fill' => true,
                ],
                [
                    'label' => "Prediksi {$jumlahHariPrediksi} Hari",
                    'data' => array_merge(
                        array_fill(0, count($historicalData), null),
                        $predictedData->values()->toArray()
                    ),
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'borderWidth' => 2,
                    'borderDash' => [5, 5],
                    'tension' => 0.3,
                    'pointRadius' => 3,
                    'pointHoverRadius' => 5,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
            'metadata' => [
                'algorithm' => 'Enhanced Holt-Winters',
                'parameters' => [
                    'alpha' => round($alpha, 3),
                    'beta' => round($beta, 3),
                    'gamma' => round($gamma, 3),
                    'volatility' => round($volatility, 3),
                    'trend_strength' => round($recentTrend, 3),
                ],
                'statistics' => [
                    'historical_avg' => round($avgOrders, 2),
                    'prediction_avg' => round($predictedData->avg(), 2),
                    'confidence_range' => [
                        'min' => min(array_column($confidenceIntervals, 'lower')),
                        'max' => max(array_column($confidenceIntervals, 'upper'))
                    ]
                ]
            ]
        ];
    }

    private function calculateTrend(Collection $data): float
    {
        $n = $data->count();
        if ($n < 2) return 0;
        
        $values = $data->values()->toArray();
        $x = range(1, $n);
        
        $sumX = array_sum($x);
        $sumY = array_sum($values);
        $sumXY = array_sum(array_map(fn($i) => $x[$i] * $values[$i], range(0, $n-1)));
        $sumX2 = array_sum(array_map(fn($v) => $v * $v, $x));
        
        return ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
    }

    private function calculateInitialLevel(Collection $data, int $seasonLength): float
    {
        return $data->take($seasonLength * 2)->avg();
    }

    private function calculateInitialTrend(Collection $data, int $seasonLength): float
    {
        $values = $data->values()->toArray();
        $n = min(count($values), $seasonLength * 2);
        
        if ($n < $seasonLength * 2) return 0;
        
        $firstSeason = array_slice($values, 0, $seasonLength);
        $secondSeason = array_slice($values, $seasonLength, $seasonLength);
        
        $trend = (array_sum($secondSeason) - array_sum($firstSeason)) / ($seasonLength * $seasonLength);
        
        return $trend;
    }

    private function calculateInitialSeasonal(Collection $data, int $seasonLength, float $avgOrders): array
    {
        $seasonal = array_fill(0, $seasonLength, 0);
        $seasonalCounts = array_fill(0, $seasonLength, 0);
        
        foreach ($data as $date => $value) {
            $dayOfWeek = Carbon::parse($date)->dayOfWeek;
            $seasonal[$dayOfWeek] += $value;
            $seasonalCounts[$dayOfWeek]++;
        }
        
        // Calculate average for each day and normalize
        for ($i = 0; $i < $seasonLength; $i++) {
            if ($seasonalCounts[$i] > 0) {
                $seasonal[$i] = ($seasonal[$i] / $seasonalCounts[$i]) - $avgOrders;
            }
        }
        
        return $seasonal;
    }

    private function calculateCyclicalComponent(int $dayAhead, float $avgOrders): float
    {
        // Very subtle cyclical patterns - reduced amplitude
        $monthlyEffect = sin(2 * pi() * $dayAhead / 30) * ($avgOrders * 0.02); // Reduced from 0.05
        $quarterlyEffect = cos(2 * pi() * $dayAhead / 90) * ($avgOrders * 0.01); // Reduced from 0.03
        
        return $monthlyEffect + $quarterlyEffect;
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'animation' => ['duration' => 1000],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                    'align' => 'center',
                    'labels' => [
                        'boxWidth' => 16,
                        'padding' => 20,
                        'font' => ['size' => 14, 'weight' => 'bold'],
                        'usePointStyle' => true,
                    ],
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'titleFont' => ['size' => 14, 'weight' => 'bold'],
                    'bodyFont' => ['size' => 13],
                    'padding' => 12,
                    'cornerRadius' => 8,
                ],
                'datalabels' => ['display' => false],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['display' => true, 'color' => 'rgba(0, 0, 0, 0.05)'],
                    'ticks' => [
                        'maxRotation' => 45,
                        'minRotation' => 30,
                        'font' => ['size' => 12],
                        'autoSkip' => true,
                        'maxTicksLimit' => 20,
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Tanggal',
                        'font' => ['size' => 14, 'weight' => 'bold'],
                        'padding' => ['top' => 20],
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => ['drawBorder' => false, 'color' => 'rgba(0, 0, 0, 0.05)'],
                    'ticks' => [
                        'stepSize' => 10,
                        'font' => ['size' => 12],
                        'padding' => 10,
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Pesanan',
                        'font' => ['size' => 14, 'weight' => 'bold'],
                        'padding' => ['bottom' => 20],
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getExtraStyles(): array
    {
        return [
            'wrapper' => 'w-full overflow-x-auto bg-white rounded-xl shadow-lg p-6',
            'chart' => 'min-w-full h-full',
        ];
    }

    protected function getExtraAttributes(): array
    {
        return [
            'style' => 'min-height: 600px;',
        ];
    }
}

//PREDIKSI DARI 2023 APRIL 01 - 2025 APRIL 31

//     protected function getData(): array
// {
//     // Step 1: Range data tetap (2023-04-01 s.d. 2025-04-30)
//     $startDate = '2023-04-01';
//     $endDate = '2025-04-30';

//     // Ambil semua order dari tanggal tersebut dan grupkan per hari
//     $rawData = Order::query()
//         ->whereBetween('tgl_pesan', [$startDate, $endDate])
//         ->get()
//         ->groupBy(fn($order) => \Carbon\Carbon::parse($order->tgl_pesan)->format('Y-m-d'))
//         ->map(fn($group) => $group->count());

//     // Normalisasi semua tanggal dari 2023-04-01 s.d. 2025-04-30
//     $dates = collect();
//     $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
//     foreach ($period as $date) {
//         $formatted = $date->format('Y-m-d');
//         $dates->put($formatted, $rawData[$formatted] ?? 0);
//     }

//     // Step 2: Single Exponential Smoothing
//     $alpha = 0.9;
//     $St = null;
//     $forecast = [];

//     foreach ($dates as $date => $actual) {
//         if (is_null($St)) {
//             $St = $actual;
//         } else {
//             $St = $alpha * $actual + (1 - $alpha) * $St;
//         }
//         $forecast[$date] = round($St, 2);
//     }

//     // Step 3: Prediksi untuk hari ke-31 → 2025-05-01
//     $nextDate = '2025-05-01';
//     $forecast[$nextDate] = round($St, 2);

//     dd($forecast);

//     return [
//         'datasets' => [
//             [
//                 'label' => 'Prediksi Pesanan (SES)',
//                 'data' => array_values($forecast),
//                 'borderColor' => '#6366f1',
//                 'backgroundColor' => 'rgba(99, 102, 241, 0.3)',
//             ],
//         ],
//         'labels' => array_keys($forecast),
//     ];
// }