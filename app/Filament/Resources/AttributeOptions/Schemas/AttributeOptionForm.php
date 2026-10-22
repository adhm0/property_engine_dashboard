<?php

namespace App\Filament\Resources\AttributeOptions\Schemas;

use App\Filament\Support\TranslationFields;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AttributeOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('attribute_id')
                    ->label('معرّف السمة')
                    ->required(),
                TextInput::make('value')
                    ->required(),
                TextInput::make('icon')
                    ->label('الأيقونة'),
                TextInput::make('sort_order')
                    ->label('ترتيب العرض')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->required()
                    ->label('نشط')
                    ->required(),

                TranslationFields::make([
                    'value' => ['label' => 'اسم الخيار', 'maxLength' => 80],
                ]),
            ]);
    }
}
