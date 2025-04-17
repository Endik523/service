<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MasalahKerusakanResource\Pages;
use App\Filament\Resources\MasalahKerusakanResource\RelationManagers;
use App\Models\DamageDetail; // Pastikan untuk menggunakan model yang benar
use App\Models\DamageDetails;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\NumberColumn;

class MasalahKerusakanResource extends Resource
{
    protected static ?string $model = DamageDetails::class;
    protected static ?string $navigationGroup = 'Orders';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id_order')
                    ->label('ID ORDER (bukan id random)')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('harga_barang')
                    ->label('Harga Barang')
                    ->numeric()
                    ->maxLength(10),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('id_order')
                    ->label('ID Order')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('harga_barang')
                    ->label('Harga Barang')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMasalahKerusakans::route('/'),
            'create' => Pages\CreateMasalahKerusakan::route('/create'),
            'edit' => Pages\EditMasalahKerusakan::route('/{record}/edit'),
        ];
    }
}
