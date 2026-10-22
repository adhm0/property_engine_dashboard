<?php

namespace App\Filament\Resources\BookableUnits\Pages;

use App\Filament\Resources\BookableUnits\BookableUnitResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBookableUnit extends ViewRecord
{
    protected static string $resource = BookableUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
