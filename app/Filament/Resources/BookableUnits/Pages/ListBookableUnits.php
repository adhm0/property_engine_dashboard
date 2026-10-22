<?php

namespace App\Filament\Resources\BookableUnits\Pages;

use App\Filament\Resources\BookableUnits\BookableUnitResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookableUnits extends ListRecords
{
    protected static string $resource = BookableUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
