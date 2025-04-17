<?php

namespace App\Filament\Resources\User2Resource\Pages;

use App\Filament\Resources\User2Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser2 extends EditRecord
{
    protected static string $resource = User2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
