<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KurirResource\Pages;
use App\Filament\Resources\KurirResource\RelationManagers;
use App\Models\Kurir;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KurirResource extends Resource
{
    protected static ?string $model = Kurir::class;

    protected static ?string $navigationGroup = 'Management Order';
    protected static ?string $navigationLabel = 'Kurir';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('order_id')
                //     ->label('Order')
                //     ->options(function () {
                //         // Ambil data dari model Order dan gabungkan 'id', 'username', dan 'tgl_pesan'
                //         return \App\Models\Order::all()->mapWithKeys(function ($order) {
                //             // Pastikan tgl_pesan menjadi objek Carbon
                //             $tglPesanFormatted = \Carbon\Carbon::parse($order->tgl_pesan)->format('Y-m-d');
                //             return [
                //                 $order->id => $order->id . ' - ' . $order->username . ' - ' . $tglPesanFormatted
                //             ];
                //         });
                //     })
                //     ->required(),
                Forms\Components\Select::make('order_id')
                    ->label('Order')
                    ->options(function () {
                        // Hanya tampilkan order yang jemput_barang = 'YES' dan belum memiliki kurir
                        return \App\Models\Order::where('jemput_barang', 'YES')
                            ->whereDoesntHave('kurir')
                            ->get()
                            ->mapWithKeys(function ($order) {
                                $tglPesanFormatted = \Carbon\Carbon::parse($order->tgl_pesan)->format('Y-m-d');
                                return [
                                    $order->id => $order->id_random . ' - ' . $order->username . ' - ' . $tglPesanFormatted
                                ];
                            });
                    })
                    ->required()
                    ->default(function () {
                        // Jika ada parameter order_id di URL, gunakan sebagai default
                        if (request()->has('order_id')) {
                            return request()->get('order_id');
                        }
                        return null;
                    })
                    ->disabled(fn(string $operation): bool => $operation === 'edit') // Nonaktifkan saat edit
                    ->hidden(fn(string $operation): bool => $operation === 'edit'), // Sembunyikan saat edit

                Forms\Components\TextInput::make('name')
                    ->label('Nama Kurir')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('photo')
                    ->label('Foto (URL)')
                    ->nullable()
                    ->helperText('Masukkan URL atau path relatif foto kurir'),

                Forms\Components\TextInput::make('plat_motor')
                    ->label('Plat Motor')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('merk_motor')
                    ->label('Merk Motor')
                    ->required()
                    ->maxLength(255),


            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kurir')
                    ->searchable(),

                ImageColumn::make('photo')
                    ->label('Foto'),

                TextColumn::make('plat_motor')
                    ->label('Plat Motor'),

                TextColumn::make('merk_motor')
                    ->label('Merk Motor'),

                TextColumn::make('order.username')
                    ->label('Pelanggan')
                    ->searchable(),

                TextColumn::make('order.barang')
                    ->label('Barang'),

                TextColumn::make('order.alamat')
                    ->label('Alamat Jemput'),
            ])
            ->filters([
                // Filter tambahan jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKurir::route('/'),
            'create' => Pages\CreateKurir::route('/create'),
            'edit' => Pages\EditKurir::route('/{record}/edit'),
        ];
    }
}
