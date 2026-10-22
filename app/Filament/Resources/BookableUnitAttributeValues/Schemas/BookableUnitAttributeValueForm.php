<?php

namespace App\Filament\Resources\BookableUnitAttributeValues\Schemas;

use App\Models\AttributeDefinition;
use App\Models\AttributeOption;
use App\Models\BookableUnit;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class BookableUnitAttributeValueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('unit_id')
                    ->label('الوحدة')
                    ->relationship('unit', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set): void {
                        $set('attribute_id', null);
                        static::resetValues($set);
                    }),
                Select::make('attribute_id')
                    ->label('السمة')
                    ->options(fn (Get $get): array => static::attributeOptions($get('unit_id')))
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => static::resetValues($set)),
                Textarea::make('value_string')
                    ->label('القيمة النصية')
                    ->visible(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'TEXT')
                    ->dehydrated(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'TEXT')
                    ->columnSpanFull(),
                TextInput::make('value_number')
                    ->label('القيمة الرقمية')
                    ->numeric()
                    ->visible(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'NUMBER')
                    ->dehydrated(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'NUMBER'),
                Toggle::make('value_boolean')
                    ->label('القيمة المنطقية')
                    ->visible(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'BOOLEAN')
                    ->dehydrated(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'BOOLEAN'),
                DateTimePicker::make('value_date')
                    ->label('التاريخ / الوقت')
                    ->visible(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'DATE')
                    ->dehydrated(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'DATE'),
                KeyValue::make('value_json')
                    ->label('قيمة JSON')
                    ->keyLabel('المفتاح')
                    ->valueLabel('القيمة')
                    ->visible(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'JSON')
                    ->dehydrated(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'JSON')
                    ->columnSpanFull(),
                Select::make('option_id')
                    ->label('الخيار')
                    ->options(fn (Get $get): array => static::optionOptions($get('attribute_id')))
                    ->visible(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'ENUM')
                    ->dehydrated(fn (Get $get): bool => static::valueType($get('attribute_id')) === 'ENUM')
                    ->native(false),
            ]);
    }

    protected static function valueType(?string $attributeId): ?string
    {
        if (blank($attributeId)) {
            return null;
        }

        return AttributeDefinition::find($attributeId)?->value_type;
    }

    protected static function attributeOptions(?string $unitId): array
    {
        if (blank($unitId)) {
            return [];
        }

        $unit = BookableUnit::find($unitId);

        if (! $unit) {
            return [];
        }

        return $unit->applicableAttributes()
            ->mapWithKeys(fn ($unitTypeAttribute) => [
                $unitTypeAttribute->attribute_id => $unitTypeAttribute->attribute->translation('key')
                    ?: $unitTypeAttribute->attribute->key,
            ])
            ->all();
    }

    protected static function optionOptions(?string $attributeId): array
    {
        if (blank($attributeId)) {
            return [];
        }

        return AttributeOption::query()
            ->where('attribute_id', $attributeId)
            ->where('is_active', true)
            ->get()
            ->mapWithKeys(fn (AttributeOption $option) => [
                $option->id => $option->translation('value') ?: $option->value,
            ])
            ->all();
    }

    protected static function resetValues(Set $set): void
    {
        $set('value_string', null);
        $set('value_number', null);
        $set('value_boolean', null);
        $set('value_date', null);
        $set('value_json', null);
        $set('option_id', null);
    }
}
