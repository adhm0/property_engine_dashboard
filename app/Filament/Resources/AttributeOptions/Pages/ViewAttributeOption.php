<?php

namespace App\Filament\Resources\AttributeOptions\Pages;

use App\Filament\Resources\AttributeOptions\AttributeOptionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAttributeOption extends ViewRecord
{
    protected static string $resource = AttributeOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
