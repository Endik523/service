<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatResource\Pages;
use App\Filament\Resources\RiwayatResource\RelationManagers;
use App\Models\Order;
use App\Models\Riwayat;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiwayatResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Riwayat Order';
    protected static ?string $modelLabel = 'Riwayat Order';
    // protected static ?string $navigationGroup = 'Order Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('id_random')
                //     ->required()
                //     ->maxLength(7),
                // Forms\Components\TextInput::make('username')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('barang')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\Textarea::make('alamat')
                //     ->required(),
                // Forms\Components\DatePicker::make('tgl_pesan')
                //     ->required(),
                // Forms\Components\Textarea::make('pesan')
                //     ->required(),
                // Forms\Components\Select::make('jemput_barang')
                //     ->options([
                //         'YES' => 'Ya',
                //         'NO' => 'Tidak'
                //     ]),
                // Forms\Components\Select::make('status')
                //     ->label('Status Pesanan')
                //     ->options(Order::getStatuses())
                //     ->required(),
                // Forms\Components\Select::make('jemput_barang')
                //     ->label('Jemput Barang')
                //     ->options([
                //         'YES' => 'Ya',
                //         'NO' => 'Tidak'
                //     ])
                //     ->required(),
                Forms\Components\Textarea::make('masalah_kerusakan')
                    ->required(),
            ]);
    }

    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             Tables\Columns\TextColumn::make('id_random')
    //                 ->sortable()
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('username')
    //                 ->sortable()
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('barang')
    //                 ->sortable()
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('status')
    //                 ->label('Status')
    //                 ->formatStateUsing(fn(string $state): string => Order::getStatuses()[$state] ?? $state)
    //                 ->color(fn(string $state): string => match ($state) {
    //                     Order::STATUS_PENDING => 'warning',
    //                     Order::STATUS_PENJEMPUTAN => 'info',
    //                     Order::STATUS_DIPROSES => 'primary',
    //                     Order::STATUS_SELESAI => 'success',
    //                     Order::STATUS_DIBATALKAN => 'danger',
    //                     default => 'gray',
    //                 })
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('tgl_pesan')
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('jemput_barang')
    //                 ->sortable()
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('masalah_kerusakan')
    //                 ->sortable()
    //                 ->searchable(),
    //         ])
    //         ->filters([
    //             Tables\Filters\SelectFilter::make('status')
    //                 ->options(Order::getStatuses())
    //                 ->label('Status Pesanan'),
    //         ])
    //         ->actions([
    //             Tables\Actions\EditAction::make(),
    //             Tables\Actions\ViewAction::make(), // Hanya view, tidak edit
    //         ])
    //         ->bulkActions([
    //             Tables\Actions\BulkActionGroup::make([
    //                 Tables\Actions\DeleteBulkAction::make(),
    //             ]),
    //         ]);
    // }



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
                        Order::STATUS_PEMBAYARAN => 'info',
                        Order::STATUS_DIPROSES => 'primary',
                        Order::STATUS_SELESAI => 'success',
                        Order::STATUS_DIBATALKAN => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pesan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_pesan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jemput_barang')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime('d M Y, H:i')
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime('d M Y, H:i')
                //     ->sortable(),
            ])
            ->filters([
                // Filter berdasarkan status
                Tables\Filters\SelectFilter::make('status')
                    ->options(Order::getStatuses())
                    ->label('Status Pesanan')
                    ->query(function (Builder $query, array $data) {
                        // Query filter status di Filament
                        if (!empty($data['value'])) {
                            $query->where('status', $data['value']);
                        }
                    }),
                // Tables\Filters\Filter::make('belum_ada_masalah')
                //     ->query(fn(Builder $query): Builder => $query->whereNull('masalah_kerusakan')->orWhere('masalah_kerusakan', ''))
                //     ->label('Belum Ada Masalah Kerusakan')
                //     ->default(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                // Action untuk cepat mengubah status
                Tables\Actions\Action::make('updateStatus')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Status Baru')
                            ->options(Order::getStatuses())
                            ->required(),
                    ])
                    ->action(function (Order $record, array $data) {
                        $record->status = $data['status'];
                        $record->save();
                    }),

                Tables\Actions\Action::make('assignKurir')
                    ->label('Assign Kurir')
                    ->icon('heroicon-o-truck')
                    ->visible(fn(Order $record): bool => $record->jemput_barang === 'YES' && !$record->kurir)
                    ->action(function (Order $record) {
                        return redirect()->route('filament.admin.resources.kurirs.create', [
                            'order_id' => $record->id,
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('updateStatus')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('Status Baru')
                                ->options(Order::getStatuses())
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each(function (Order $record) use ($data): void {
                                $record->status = $data['status'];
                                $record->save();
                            });
                        }),
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
            'edit' => Pages\EditRiwayat::route('/{record}/edit'),
            'view' => Pages\EditRiwayat::route('/{record}'),
        ];
    }
}
