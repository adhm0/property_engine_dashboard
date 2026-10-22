<?php

namespace App\Filament\Resources\BookableUnits\Pages;

use App\Filament\Resources\BookableUnits\BookableUnitResource;
use App\Filament\Resources\BookableUnits\Concerns\HandlesAttributeValues;
use Filament\Resources\Pages\CreateRecord;

class CreateBookableUnit extends CreateRecord
{
    use HandlesAttributeValues;

    protected static string $resource = BookableUnitResource::class;
}
