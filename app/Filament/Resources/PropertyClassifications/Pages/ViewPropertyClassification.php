<?php

namespace App\Filament\Resources\PropertyClassifications\Pages;

use App\Filament\Resources\PropertyClassifications\PropertyClassificationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPropertyClassification extends ViewRecord
{
    protected static string $resource = PropertyClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
