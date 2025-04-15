<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationGroup = 'Orders';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('random_id')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('username')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('barang')
                ->required()
                ->maxLength(255),
            Forms\Components\Textarea::make('alamat')
                ->required(),
            Forms\Components\DatePicker::make('tgl_pesan')
                ->required(),
            Forms\Components\Textarea::make('pesan')
                ->required(),
            Forms\Components\Textarea::make('jemput_barang')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('random_id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('username')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('barang')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('alamat')->sortable(),
                Tables\Columns\TextColumn::make('tgl_pesan')->sortable(),
                Tables\Columns\TextColumn::make('pesan')->sortable(),
                Tables\Columns\TextColumn::make('jemput_barang')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y, H:i')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListOrders::route('/'),
            // 'create' => Pages\CreateOrder::route('/create'),
            // 'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
