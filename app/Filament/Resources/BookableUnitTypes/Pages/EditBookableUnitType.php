<?php

namespace App\Filament\Resources\BookableUnitTypes\Pages;

use App\Filament\Resources\BookableUnitTypes\BookableUnitTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBookableUnitType extends EditRecord
{
    protected static string $resource = BookableUnitTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
