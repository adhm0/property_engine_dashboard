<?php

namespace App\Filament\Resources\BookableUnitAttributeValues\Pages;

use App\Filament\Resources\BookableUnitAttributeValues\BookableUnitAttributeValueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookableUnitAttributeValues extends ListRecords
{
    protected static string $resource = BookableUnitAttributeValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
