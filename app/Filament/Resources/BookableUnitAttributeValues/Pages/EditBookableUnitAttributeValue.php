<?php

namespace App\Filament\Resources\BookableUnitAttributeValues\Pages;

use App\Filament\Resources\BookableUnitAttributeValues\BookableUnitAttributeValueResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBookableUnitAttributeValue extends EditRecord
{
    protected static string $resource = BookableUnitAttributeValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
