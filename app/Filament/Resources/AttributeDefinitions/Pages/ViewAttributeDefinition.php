<?php

namespace App\Filament\Resources\AttributeDefinitions\Pages;

use App\Filament\Resources\AttributeDefinitions\AttributeDefinitionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAttributeDefinition extends ViewRecord
{
    protected static string $resource = AttributeDefinitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
