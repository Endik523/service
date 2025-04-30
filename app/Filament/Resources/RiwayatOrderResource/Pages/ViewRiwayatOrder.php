<?php

namespace App\Filament\Resources\RiwayatOrderResource\Pages;

use App\Filament\Resources\RiwayatOrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRiwayatOrder extends ViewRecord
{
    protected static string $resource = RiwayatOrderResource::class;

    protected function resolveRecord(int | string $key): Order
    {
        return parent::resolveRecord($key);
    }
}
