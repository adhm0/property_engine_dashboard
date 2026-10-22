<?php

namespace App\Filament\Resources\AttributeGroups\Pages;

use App\Filament\Resources\AttributeGroups\AttributeGroupResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAttributeGroup extends ViewRecord
{
    protected static string $resource = AttributeGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
