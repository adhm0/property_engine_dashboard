<?php

namespace App\Filament\Resources\PropertyRules\Pages;

use App\Filament\Resources\PropertyRules\PropertyRuleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPropertyRules extends ListRecords
{
    protected static string $resource = PropertyRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
