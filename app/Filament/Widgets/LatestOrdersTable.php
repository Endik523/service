<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

use Illuminate\Support\Facades\Auth;

class LatestOrdersTable extends TableWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Tabel Orderan';

    public static function canView(): bool
    {
        return Auth::user()?->role !== 'teknisi';
    }

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
                ->label('Status')
                ->formatStateUsing(fn(string $state): string => Order::getStatuses()[$state] ?? $state)
                ->colors([
                    Order::STATUS_PENDING => 'warning',
                    Order::STATUS_PENJEMPUTAN => 'info',
                    Order::STATUS_PEMBAYARAN => 'info',
                    Order::STATUS_DIPROSES => 'primary',
                    Order::STATUS_SELESAI => 'success',
                    Order::STATUS_DIBATALKAN => 'danger',
                ]),

            TextColumn::make('created_at')
                ->label('Tanggal')
                ->dateTime('d M Y'),
        ];
    }
}
