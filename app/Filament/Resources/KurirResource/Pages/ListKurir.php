<?php

namespace App\Filament\Resources\KurirResource\Pages;

use App\Filament\Resources\KurirResource;
use App\Models\Kurir;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKurir extends ListRecords
{
    protected static string $resource = KurirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
