<?php

namespace App\Filament\Resources\BookableUnits\Schemas;

use App\Filament\Support\TranslationFields;
use App\Models\UnitTypeAttribute;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class BookableUnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل الوحدة')
                    ->description('إعداد وحدة المخزون القابلة للحجز والتسعير')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('اسم الوحدة')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('مثال: جناح غرفة النوم الرئيسية بالفيلا'),
                                Select::make('status')
                                    ->label('الحالة')
                                    ->options([
                                        'ACTIVE' => 'نشط',
                                        'INACTIVE' => 'غير نشط',
                                        'MAINTENANCE' => 'قيد الصيانة',
                                        'BOOKED' => 'محجوز',
                                    ])
                                    ->default('ACTIVE')
                                    ->required()
                                    ->native(false),
                                Select::make('property_id')
                                    ->relationship('property', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('العقار الرئيسي'),
                                Select::make('unit_type_id')
                                    ->relationship('unitType', 'code')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->label('نوع الوحدة'),
                                TextInput::make('capacity')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->default(2)
                                    ->label('سعة الضيوف'),
                                TextInput::make('base_price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('$')
                                    ->label('السعر الأساسي (لكل ليلة)'),
                                TextInput::make('offer_price')
                                    ->numeric()
                                    ->prefix('$')
                                    ->label('السعر المخفّض / العرض'),
                            ]),
                    ]),

                Section::make('سمات الوحدة')
                    ->description('السمات المحددة لنوع الوحدة. يتم حفظ القيم في محرك السمات تلقائياً، وتوليد بيانات الفلترة.')
                    ->schema(fn (Get $get): array => static::attributeFields($get('unit_type_id')))
                    ->columns(2)
                    ->collapsible(),

                TranslationFields::make([
                    'name' => ['label' => 'اسم الوحدة', 'maxLength' => 150],
                ]),
            ]);
    }

    public static function attributeFields(?string $unitTypeId): array
    {
        if (blank($unitTypeId)) {
            return [
                Placeholder::make('unit_type_prompt')
                    ->content('اختر نوع الوحدة أولاً لعرض السمات المخصصة لها.')
                    ->columnSpanFull(),
            ];
        }

        $unitTypeAttributes = UnitTypeAttribute::query()
            ->with(['attribute.options'])
            ->where('unit_type_id', $unitTypeId)
            ->whereHas('attribute', fn ($query) => $query->where('is_active', true))
            ->orderBy('sort_order')
            ->get();

        if ($unitTypeAttributes->isEmpty()) {
            return [
                Placeholder::make('no_unit_type_attributes')
                    ->content('لا توجد سمات مكوّنة لهذا النوع من الوحدات.')
                    ->columnSpanFull(),
            ];
        }

        return $unitTypeAttributes
            ->map(fn (UnitTypeAttribute $unitTypeAttribute) => static::attributeField($unitTypeAttribute))
            ->all();
    }

    protected static function attributeField(UnitTypeAttribute $unitTypeAttribute)
    {
        $definition = $unitTypeAttribute->attribute;
        $path = "attribute_values_data.{$definition->id}";

        $label = $definition->translation('key') ?: $definition->key;

        if (filled($definition->unit_code)) {
            $label .= " ({$definition->unit_code})";
        }

        $component = match ($definition->value_type) {
            'NUMBER' => TextInput::make("{$path}.value_number")
                ->numeric(),
            'BOOLEAN' => Toggle::make("{$path}.value_boolean")
                ->default(false),
            'DATE' => DateTimePicker::make("{$path}.value_date"),
            'JSON' => KeyValue::make("{$path}.value_json")
                ->keyLabel('المفتاح')
                ->valueLabel('القيمة'),
            'ENUM' => Select::make("{$path}.option_id")
                ->options(
                    $definition->options
                        ->where('is_active', true)
                        ->mapWithKeys(fn ($option) => [
                            $option->id => $option->translation('value') ?: $option->value,
                        ])
                        ->all()
                )
                ->native(false),
            default => TextInput::make("{$path}.value_string"),
        };

        return $component
            ->label($label)
            ->required($unitTypeAttribute->is_required && $definition->value_type !== 'BOOLEAN');
    }
}
