<?php

namespace App\Filament\Resources\PropertyRules\Pages;

use App\Filament\Resources\PropertyRules\PropertyRuleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPropertyRule extends EditRecord
{
    protected static string $resource = PropertyRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
