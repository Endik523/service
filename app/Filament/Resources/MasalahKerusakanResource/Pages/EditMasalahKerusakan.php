<?php

namespace App\Filament\Resources\MasalahKerusakanResource\Pages;

use App\Filament\Resources\MasalahKerusakanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasalahKerusakan extends EditRecord
{
    protected static string $resource = MasalahKerusakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
