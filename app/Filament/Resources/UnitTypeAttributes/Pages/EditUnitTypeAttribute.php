<?php

namespace App\Filament\Resources\UnitTypeAttributes\Pages;

use App\Filament\Resources\UnitTypeAttributes\UnitTypeAttributeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUnitTypeAttribute extends EditRecord
{
    protected static string $resource = UnitTypeAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
