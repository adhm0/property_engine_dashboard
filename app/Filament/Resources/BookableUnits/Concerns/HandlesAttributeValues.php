<?php

namespace App\Filament\Resources\BookableUnits\Concerns;

trait HandlesAttributeValues
{
    protected array $attributeValuesData = [];

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['attribute_values_data'] = $this->record->attributeValuesForForm();

        return $data;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->attributeValuesData = $data['attribute_values_data'] ?? [];

        unset($data['attribute_values_data']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->syncAttributeValues($this->attributeValuesData);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->attributeValuesData = $data['attribute_values_data'] ?? [];

        unset($data['attribute_values_data']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->syncAttributeValues($this->attributeValuesData);
    }
}
