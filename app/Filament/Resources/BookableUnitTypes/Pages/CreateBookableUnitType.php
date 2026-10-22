<?php

namespace App\Filament\Resources\BookableUnitTypes\Pages;

use App\Filament\Resources\BookableUnitTypes\BookableUnitTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookableUnitType extends CreateRecord
{
    protected static string $resource = BookableUnitTypeResource::class;
}
