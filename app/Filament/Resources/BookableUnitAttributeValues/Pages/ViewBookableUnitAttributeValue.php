<?php

namespace App\Filament\Resources\BookableUnitAttributeValues\Pages;

use App\Filament\Resources\BookableUnitAttributeValues\BookableUnitAttributeValueResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBookableUnitAttributeValue extends ViewRecord
{
    protected static string $resource = BookableUnitAttributeValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
