<?php

namespace App\Filament\Resources\PropertyRules\Pages;

use App\Filament\Resources\PropertyRules\PropertyRuleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPropertyRule extends ViewRecord
{
    protected static string $resource = PropertyRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
