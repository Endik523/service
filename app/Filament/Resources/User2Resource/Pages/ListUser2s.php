<?php

namespace App\Filament\Resources\User2Resource\Pages;

use App\Filament\Resources\User2Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUser2s extends ListRecords
{
    protected static string $resource = User2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
