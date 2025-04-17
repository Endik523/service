<?php

namespace App\Filament\Resources\MasalahKerusakanResource\Pages;

use App\Filament\Resources\MasalahKerusakanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasalahKerusakans extends ListRecords
{
    protected static string $resource = MasalahKerusakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
