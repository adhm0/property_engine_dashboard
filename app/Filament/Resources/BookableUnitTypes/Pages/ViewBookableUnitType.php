<?php

namespace App\Filament\Resources\BookableUnitTypes\Pages;

use App\Filament\Resources\BookableUnitTypes\BookableUnitTypeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBookableUnitType extends ViewRecord
{
    protected static string $resource = BookableUnitTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
