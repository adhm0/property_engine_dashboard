<?php

namespace App\Filament\Resources\PropertyTypeClassifications\Pages;

use App\Filament\Resources\PropertyTypeClassifications\PropertyTypeClassificationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPropertyTypeClassification extends ViewRecord
{
    protected static string $resource = PropertyTypeClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
