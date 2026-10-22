<?php

namespace App\Filament\Resources\BookableUnits\Pages;

use App\Filament\Resources\BookableUnits\BookableUnitResource;
use App\Filament\Resources\BookableUnits\Concerns\HandlesAttributeValues;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBookableUnit extends EditRecord
{
    use HandlesAttributeValues;

    protected static string $resource = BookableUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
