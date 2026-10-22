<?php

namespace App\Filament\Resources\PropertyClassifications\Pages;

use App\Filament\Resources\PropertyClassifications\PropertyClassificationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPropertyClassification extends EditRecord
{
    protected static string $resource = PropertyClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
