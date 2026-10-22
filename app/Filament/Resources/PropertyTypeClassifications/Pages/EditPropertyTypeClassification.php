<?php

namespace App\Filament\Resources\PropertyTypeClassifications\Pages;

use App\Filament\Resources\PropertyTypeClassifications\PropertyTypeClassificationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPropertyTypeClassification extends EditRecord
{
    protected static string $resource = PropertyTypeClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
