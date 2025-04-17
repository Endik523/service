<?php

namespace App\Filament\Resources\KurirResource\Pages;

use App\Filament\Resources\KurirResource;
use App\Models\Kurir;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKurir extends CreateRecord
{
    protected static string $resource = KurirResource::class;
}
