<?php

namespace App\Filament\Resources\UnitTypeAttributes\Pages;

use App\Filament\Resources\UnitTypeAttributes\UnitTypeAttributeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUnitTypeAttributes extends ListRecords
{
    protected static string $resource = UnitTypeAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
