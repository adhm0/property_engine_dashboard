<?php

namespace App\Filament\Resources\UnitTypeAttributes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class UnitTypeAttributeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Select::make('unit_type_id')
                            ->label('نوع الوحدة')
                            ->relationship('unitType', 'code')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('attribute_id')
                            ->label('السمة')
                            ->relationship('attribute', 'key')
                            ->getOptionLabelFromRecordUsing(
                                fn ($record) => $record->translation('key') ?: $record->key
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        Toggle::make('is_required')
                            ->label('مطلوبة')
                            ->default(false),
                        Toggle::make('is_filterable')
                            ->label('قابلة للفلترة')
                            ->default(false),
                        Toggle::make('is_displayable')
                            ->label('تظهر في الواجهة')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->label('ترتيب العرض')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }
}
