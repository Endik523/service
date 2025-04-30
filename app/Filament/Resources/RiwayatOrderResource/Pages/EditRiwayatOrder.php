<?php

namespace App\Filament\Resources\RiwayatOrderResource\Pages;

use App\Filament\Resources\RiwayatOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatOrder extends EditRecord
{
    protected static string $resource = RiwayatOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
