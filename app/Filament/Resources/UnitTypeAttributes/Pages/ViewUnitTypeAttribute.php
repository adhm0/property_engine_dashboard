<?php

namespace App\Filament\Resources\UnitTypeAttributes\Pages;

use App\Filament\Resources\UnitTypeAttributes\UnitTypeAttributeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUnitTypeAttribute extends ViewRecord
{
    protected static string $resource = UnitTypeAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
