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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Input untuk Nama Kurir
                Forms\Components\TextInput::make('name')
                    ->label('Nama Kurir')
                    ->required()
                    ->maxLength(255),

                // Input untuk Foto (URL atau Path Relatif)
                Forms\Components\TextInput::make('photo')
                    ->label('Foto (URL)')
                    ->nullable() // Menjadikan input ini opsional
                    ->helperText('Masukkan URL atau path relatif foto kurir'),

                // Input untuk Plat Motor
                Forms\Components\TextInput::make('plat_motor')
                    ->label('Plat Motor')
                    ->required()
                    ->maxLength(255),

                // Input untuk Merk Motor
                Forms\Components\TextInput::make('merk_motor')
                    ->label('Merk Motor')
                    ->required()
                    ->maxLength(255),

                // Relasi dengan Order (menggunakan order_id sebagai foreign key)
                Forms\Components\Select::make('order_id')
                    ->label('Order')
                    ->relationship('order', 'id') // Menampilkan random_id dari Order
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom untuk Nama Kurir
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kurir'),

                // Kolom untuk Foto Kurir (URL atau asset)
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->getStateUsing(function ($record) {
                        $photo = $record->photo;

                        // Jika foto adalah URL eksternal, tampilkan langsung
                        if (filter_var($photo, FILTER_VALIDATE_URL)) {
                            return $photo;
                        }

                        // Jika foto adalah path relatif, gunakan asset() untuk mendapatkan URL lengkap
                        return asset($photo); // Menampilkan gambar dari folder public
                    }),

                // Kolom untuk Plat Motor
                Tables\Columns\TextColumn::make('plat_motor')
                    ->label('Plat Motor'),

                // Kolom untuk Merk Motor
                Tables\Columns\TextColumn::make('merk_motor')
                    ->label('Merk Motor'),

                // Kolom untuk Order ID (mengambil data dari relasi)
                Tables\Columns\TextColumn::make('order.id')
                    ->label('Order ID'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKurirs::route('/'),
            'create' => Pages\CreateKurir::route('/create'),
            'edit' => Pages\EditKurir::route('/{record}/edit'),
        ];
    }
}
