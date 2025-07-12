<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Collection;

class OrderChart extends Widget implements HasForms
{
    use InteractsWithForms;
    use InteractsWithPageFilters;

    protected static string $view = 'filaments.widgets.order-chart';
    protected static ?string $heading = 'Prediksi Pesanan';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $contentHeight = 500;

    public ?string $timeRange = '30';
    public ?string $product = 'all';
    
    protected function getFilters(): array
    {
        return [
            'timeRange' => [
                'label' => 'Durasi Prediksi',
                'options' => [
                    '7' => '7 Hari',
                    '14' => '14 Hari',
                    '30' => '30 Hari',
                    '90' => '90 Hari',
                ],
                'default' => '30'
            ],
            'product' => [
                'label' => 'Filter Barang',
                'options' => [
                    'all' => 'Semua Barang',
                    'Laptop' => 'Laptop',
                    'Handphone' => 'Handphone',
                    'Printer' => 'Printer',
                    'Komputer' => 'Komputer',
                ],
                'default' => 'all'
            ]
        ];
    }

    protected function getOptions(): array
    {
        $chartData = $this->getData();
        
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => $chartData['metadata']['product_name'] ?? 'Prediksi Pesanan'
                ],
                'legend' => [
                    'display' => true,
                    'position' => 'top'
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                    'callbacks' => [
                        'label' => function($context) {
                            return $context->dataset->label . ': ' . $context->parsed->y + ' pesanan';
                        }
                    ]
                ]
            ],
            'scales' => [
                'x' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Tanggal'
                    ]
                ],
                'y' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Pesanan'
                    ],
                    'beginAtZero' => true
                ]
            ]
        ];
    }

    protected function getChartWrapperAttributes(): string
    {
        return 'class="chart-container" style="position: relative; height: 500px;"';
    }

    protected function getContentHeight(): int
    {
        return static::$contentHeight ?? 500;
    }

    protected function getFiltersForm(): Form
    {
        return Form::make($this)
            ->schema([
                Select::make('timeRange')
                    ->label('Durasi Prediksi')
                    ->options([
                        '7' => '7 Hari',
                        '14' => '14 Hari',
                        '30' => '30 Hari',
                        '90' => '90 Hari',
                    ])
                    ->default('30'),
                    
                Select::make('product')
                    ->label('Filter Barang')
                    ->options([
                        'all' => 'Semua Barang',
                        'Laptop' => 'Laptop',
                        'Handphone' => 'Handphone',
                        'Printer' => 'Printer',
                        'Komputer' => 'Komputer',
                    ])
                    ->default('all'),
            ]);
    }

    protected function getData(): array
    {
        // Fix: Use proper filter access
        $jumlahHariPrediksi = intval($this->timeRange ?? 30);
        $productFilter = $this->product ?? 'all';
        
        $startDate = '2023-04-01';
        $endDate = now()->format('Y-m-d');
        
        // Base query dengan filter produk
        $query = Order::query()
            ->whereBetween('tgl_pesan', [$startDate, $endDate]);
            
        // Apply product filter
        if ($productFilter !== 'all' && !empty($productFilter)) {
            $query->where('barang', $productFilter);
        }

        // Get historical data with optimized query
        $rawData = $query
            ->selectRaw('DATE(tgl_pesan) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Jika tidak ada data, return empty chart
        if ($rawData->isEmpty()) {
            return [
                'datasets' => [],
                'labels' => [],
                'metadata' => [
                    'message' => 'Tidak ada data untuk filter yang dipilih',
                    'product_filter' => $productFilter
                ]
            ];
        }

        // Fill missing dates with interpolated values
        $historicalData = collect();
        $period = CarbonPeriod::create($startDate, $endDate);
        $previousValue = null;
        
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

        if ($historicalData->count() < 7) {
            return [
                'datasets' => [],
                'labels' => [],
                'metadata' => [
                    'message' => 'Data historis tidak mencukupi untuk prediksi yang akurat (minimal 7 hari)',
                    'product_filter' => $productFilter
                ]
            ];
        }

        // Calculate enhanced statistics
        $values = $historicalData->values();
        $avgOrders = $values->avg();
        $maxOrders = $values->max();
        $minOrders = $values->min();
        $stdDev = sqrt($values->map(fn($x) => pow($x - $avgOrders, 2))->avg());
        
        // Calculate volatility and trend strength
        $volatility = $avgOrders > 0 ? $stdDev / $avgOrders : 0;
        $recentTrend = $this->calculateTrend($values->slice(-min(30, $values->count())));
        
        // Conservative parameter adjustment for realistic predictions
        $alpha = min(0.4, max(0.1, 0.2 + $volatility * 0.3));
        $beta = min(0.3, max(0.05, 0.1 + abs($recentTrend) * 0.2));
        $gamma = min(0.3, max(0.05, 0.1 + $volatility * 0.2));
        $seasonLength = 7; // Weekly seasonality

        // Enhanced Holt-Winters initialization
        $level = $this->calculateInitialLevel($values, $seasonLength);
        $trend = $this->calculateInitialTrend($values, $seasonLength);
        $seasonal = $this->calculateInitialSeasonal($historicalData, $seasonLength, $avgOrders);

        // Advanced Triple Exponential Smoothing
        $forecastErrors = [];
        $adaptiveFactors = [];
        
        foreach ($historicalData as $date => $actual) {
            try {
                $dateObj = Carbon::parse($date);
                $seasonIndex = $dateObj->dayOfWeek;
                
                // Ensure seasonal array has the required index
                if (!isset($seasonal[$seasonIndex])) {
                    $seasonal[$seasonIndex] = 0;
                }
                
                // Calculate forecast for error tracking
                $forecast = $level + $trend + $seasonal[$seasonIndex];
                $error = $actual - $forecast;
                $forecastErrors[] = $error;
                
                // Adaptive learning rate based on forecast accuracy
                $adaptiveFactor = 1.0;
                if (count($forecastErrors) >= 7) {
                    $recentErrors = array_slice($forecastErrors, -7);
                    $mape = array_sum(array_map(fn($e) => abs($e), $recentErrors)) / 7;
                    $adaptiveFactor = min(1.5, max(0.5, 1.0 - ($mape / max($avgOrders, 1))));
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
            } catch (\Exception $e) {
                // Skip invalid dates or calculations
                continue;
            }
        }

        // Generate predictions for past 30 days (backtesting)
        $backtestData = collect();
        $backtestStartDate = Carbon::parse($endDate)->subDays(30);
        $backtestPeriod = CarbonPeriod::create($backtestStartDate, $endDate);
        
        foreach ($backtestPeriod as $date) {
            if ($date->format('Y-m-d') === $endDate) continue;
            
            $dateFormatted = $date->format('Y-m-d');
            $seasonIndex = $date->dayOfWeek;
            
            $daysAgo = $date->diffInDays($endDate);
            
            $trendDamping = pow(0.95, $daysAgo);
            $basePrediction = $level + ($trend * -$daysAgo * $trendDamping) + $seasonal[$seasonIndex];
            
            $meanReversionFactor = 1 - (0.02 * $daysAgo);
            $prediction = ($basePrediction * $meanReversionFactor) + ($avgOrders * (1 - $meanReversionFactor));
            
            $cyclicalComponent = $this->calculateCyclicalComponent(-$daysAgo, $avgOrders) * 0.3;
            $prediction += $cyclicalComponent;
            
            $prediction = max($minOrders * 0.5, min($maxOrders * 1.5, $prediction));
            $prediction = max(0, round($prediction));
            
            $backtestData->put($dateFormatted, $prediction);
        }

        // Generate future predictions
        $predictedData = collect();
        $lastDate = Carbon::parse($endDate);
        $confidenceIntervals = [];
        
        $residuals = array_slice($forecastErrors, -min(50, count($forecastErrors)));
        $residualStdDev = count($residuals) > 0 ? sqrt(array_sum(array_map(fn($r) => $r * $r, $residuals)) / count($residuals)) : 0;
        $noiseLevel = $residualStdDev;
        
        for ($i = 1; $i <= $jumlahHariPrediksi; $i++) {
            $nextDate = $lastDate->copy()->addDays($i);
            $seasonIndex = $nextDate->dayOfWeek;
            
            $trendDamping = pow(0.95, $i);
            $basePrediction = $level + ($trend * $i * $trendDamping) + $seasonal[$seasonIndex];
            
            $cyclicalComponent = $this->calculateCyclicalComponent($i, $avgOrders) * 0.3;
            
            $meanReversionFactor = 1 - (0.02 * $i);
            $prediction = ($basePrediction * $meanReversionFactor) + ($avgOrders * (1 - $meanReversionFactor));
            $prediction += $cyclicalComponent;
            
            $lowerBound = max(0, $minOrders * 0.5);
            $upperBound = min($maxOrders * 1.5, $avgOrders * 2);
            $prediction = max($lowerBound, min($upperBound, $prediction));
            
            $prediction = max(0, round($prediction));
            
            $predictedData->put($nextDate->format('Y-m-d'), $prediction);
            
            $confidence = 1.96 * $noiseLevel;
            $confidenceIntervals[$nextDate->format('Y-m-d')] = [
                'lower' => max($lowerBound, round($prediction - $confidence)),
                'upper' => min($upperBound, round($prediction + $confidence))
            ];
        }

        // Prepare enhanced chart data
        $labels = array_merge(
            array_keys($historicalData->toArray()),
            array_keys($backtestData->toArray()),
            array_keys($predictedData->toArray())
        );

        // Update chart heading berdasarkan filter
        $productName = $productFilter === 'all' ? 'Semua Barang' : $productFilter;
        static::$heading = "Prediksi Pesanan - {$productName}";

        return [
            'datasets' => [
                [
                    'label' => 'Data Historis',
                    'data' => array_merge(
                        $historicalData->values()->toArray(),
                        array_fill(0, count($backtestData), null),
                        array_fill(0, count($predictedData), null)
                    ),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderWidth' => 2,
                    'tension' => 0.3,
                    'pointRadius' => 2,
                    'pointHoverRadius' => 4,
                    'fill' => true,
                ],
                [
                    'label' => 'Prediksi 30 Hari Kebelakang',
                    'data' => array_merge(
                        array_fill(0, count($historicalData), null),
                        $backtestData->values()->toArray(),
                        array_fill(0, count($predictedData), null)
                    ),
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'borderWidth' => 2,
                    'borderDash' => [3, 3],
                    'tension' => 0.3,
                    'pointRadius' => 3,
                    'pointHoverRadius' => 5,
                ],
                [
                    'label' => "Prediksi {$jumlahHariPrediksi} Hari ke Depan",
                    'data' => array_merge(
                        array_fill(0, count($historicalData), null),
                        array_fill(0, count($backtestData), null),
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
                'product_filter' => $productFilter,
                'product_name' => $productName,
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
                    'total_historical_orders' => $historicalData->sum(),
                    'total_predicted_orders' => $predictedData->sum(),
                    'confidence_range' => [
                        'min' => count($confidenceIntervals) > 0 ? min(array_column($confidenceIntervals, 'lower')) : 0,
                        'max' => count($confidenceIntervals) > 0 ? max(array_column($confidenceIntervals, 'upper')) : 0
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

    protected function getType(): string
    {
        return 'line';
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

