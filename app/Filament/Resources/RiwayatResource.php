<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatResource\Pages;
use App\Filament\Resources\RiwayatResource\RelationManagers;
use App\Models\Order;
use App\Models\Riwayat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiwayatResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Riwayat';
    protected static ?string $modelLabel = 'Riwayat Order';
    // protected static ?string $navigationGroup = 'Order Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayats::route('/'),
            // 'create' => Pages\CreateRiwayat::route('/create'),
            // 'edit' => Pages\EditRiwayat::route('/{record}/edit'),
        ];
    }
}
