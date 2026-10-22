<?php

namespace App\Filament\Resources\PropertyTypeClassifications\Pages;

use App\Filament\Resources\PropertyTypeClassifications\PropertyTypeClassificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPropertyTypeClassifications extends ListRecords
{
    protected static string $resource = PropertyTypeClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
