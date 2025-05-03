<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class LatestOrdersTable extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Order::query()->latest()->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id_random')
                ->label('ID Pesanan')
                ->searchable(),

            TextColumn::make('username')
                ->label('Nama Pelanggan'),

            TextColumn::make('barang')
                ->label('Jenis Service'),

            BadgeColumn::make('status')
                ->colors([
                    'warning' => 'pending',
                    'primary' => 'processed',
                    'success' => 'completed',
                ]),

            TextColumn::make('created_at')
                ->label('Tanggal')
                ->dateTime('d M Y'),
        ];
    }
}
