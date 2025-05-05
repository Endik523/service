<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pesanan', Order::count())
                ->description('+5% dari bulan lalu')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            // Stat::make('Pesanan Proses', Order::where('status', 'processed')->count())
            //     ->description('Sedang dikerjakan')
            //     ->color('warning'),


            // Sesuaikan dengan status di OrderResource
            Stat::make('Pesanan Proses', Order::where('status', Order::STATUS_DIPROSES)->count())
                ->description('Sedang dikerjakan')
                ->color('primary'), // Warna sesuai dengan yang di OrderResource

            Stat::make('Pesanan Selesai', Order::where('status', Order::STATUS_SELESAI)->count())
                ->description('Total penyelesaian')
                ->color('success'),

            // Stat::make('Pendapatan', 'Rp ' . number_format(Order::where('status', 'completed')->sum('total_price'), 0, ',', '.'))
            //     ->description('Total pendapatan bersih')
            //     ->color('success'),

            Stat::make('Rata-rata Waktu Perbaikan', '3.2 Hari')
                ->description('Dari terima ke selesai')
                ->color('info'),
        ];
    }
}
