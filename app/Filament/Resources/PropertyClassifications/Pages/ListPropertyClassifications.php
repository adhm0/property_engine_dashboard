<?php

namespace App\Filament\Resources\PropertyClassifications\Pages;

use App\Filament\Resources\PropertyClassifications\PropertyClassificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPropertyClassifications extends ListRecords
{
    protected static string $resource = PropertyClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
