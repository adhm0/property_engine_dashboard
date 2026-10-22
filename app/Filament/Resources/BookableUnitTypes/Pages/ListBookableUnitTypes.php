<?php

namespace App\Filament\Resources\BookableUnitTypes\Pages;

use App\Filament\Resources\BookableUnitTypes\BookableUnitTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookableUnitTypes extends ListRecords
{
    protected static string $resource = BookableUnitTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
