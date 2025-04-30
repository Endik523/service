<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatOrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RiwayatOrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Riwayat Order';
    protected static ?string $modelLabel = 'Riwayat Pesanan';
    // protected static ?string $navigationGroup = 'Order Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('id_random')
                ->disabled(),
            Forms\Components\TextInput::make('username')
                ->disabled(),
            Forms\Components\TextInput::make('barang')
                ->disabled(),
            Forms\Components\Textarea::make('alamat')
                ->disabled(),
            Forms\Components\DatePicker::make('tgl_pesan')
                ->disabled(),
            Forms\Components\Textarea::make('pesan')
                ->disabled(),
            Forms\Components\Select::make('jemput_barang')
                ->disabled()
                ->options([
                    'YES' => 'Ya',
                    'NO' => 'Tidak'
                ]),
            Forms\Components\Select::make('status')
                ->label('Status Pesanan')
                ->options(Order::getStatuses())
                ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_random')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('barang')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn(string $state): string => Order::getStatuses()[$state] ?? $state)
                    ->color(fn(string $state): string => match ($state) {
                        Order::STATUS_PENDING => 'warning',
                        Order::STATUS_PENJEMPUTAN => 'info',
                        Order::STATUS_DIPROSES => 'primary',
                        Order::STATUS_SELESAI => 'success',
                        Order::STATUS_DIBATALKAN => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('tgl_pesan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jemput_barang')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(Order::getStatuses())
                    ->label('Status Pesanan'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Hanya view, tidak edit
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayatOrders::route('/'),
            'view' => Pages\ViewRiwayatOrder::route('/{record}'), // Gunakan view bukan edit
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('status', [
                Order::STATUS_SELESAI,
                Order::STATUS_DIBATALKAN
            ]); // Hanya tampilkan order selesai/dibatalkan
    }
}
