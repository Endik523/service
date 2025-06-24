<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderChart extends ChartWidget
{
    protected static ?string $heading = 'Prediksi Pesanan (Double Exponential Smoothing)';

    protected function getData(): array
    {
        // Step 1: Ambil data jumlah pesanan per hari 30 hari terakhir
        $startDate = now()->subDays(30);
        $endDate = now();

        $rawData = Order::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(fn($order) => $order->created_at->format('Y-m-d'))
            ->map(fn($group) => $group->count());

        // Normalisasi data menjadi 30 hari
        $dates = collect();
        for ($i = 0; $i <= 30; $i++) {
            $date = now()->subDays(30 - $i)->format('Y-m-d');
            $dates->put($date, $rawData[$date] ?? 0);
        }

        // Step 2: Terapkan Double Exponential Smoothing
        $alpha = 0.5; // smoothing untuk level
        $beta = 0.5;  // smoothing untuk trend

        $St = null; // level
        $Tt = 0;    // trend
        $forecast = [];

        foreach ($dates as $date => $actual) {
            if (is_null($St)) {
                // Inisialisasi pertama: level = nilai pertama, trend = 0
                $St = $actual;
                $Tt = 0;
            } else {
                $prevSt = $St;
                $St = $alpha * $actual + (1 - $alpha) * ($St + $Tt);
                $Tt = $beta * ($St - $prevSt) + (1 - $beta) * $Tt;
            }

            $forecast[$date] = round($St + $Tt, 2);
        }

        // Step 3: Prediksi hari ke-31 (besok)
        $nextDate = now()->addDay()->format('Y-m-d');
        $forecast[$nextDate] = round($St + $Tt, 2); // forecast t+1

        return [
            'datasets' => [
                [
                    'label' => 'Prediksi Pesanan (DES)',
                    'data' => array_values($forecast),
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.3)',
                ],
            ],
            'labels' => array_keys($forecast),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
