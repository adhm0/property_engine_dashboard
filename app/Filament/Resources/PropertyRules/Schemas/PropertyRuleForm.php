<?php

namespace App\Filament\Resources\PropertyRules\Schemas;

use App\Filament\Support\TranslationFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PropertyRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('property_id')
                    ->label('العقار')
                    ->relationship('property', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('code')
                    ->label('الرمز')
                    ->required()
                    ->maxLength(80),
                Select::make('type')
                    ->label('النوع')
                    ->options([
                        'TEXT' => 'نص',
                        'BOOLEAN' => 'نعم / لا',
                        'TIME' => 'وقت',
                        'MONEY' => 'مبلغ مالي',
                    ])
                    ->required()
                    ->native(false),
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
                    'code' => ['label' => 'نص القاعدة', 'maxLength' => 80],
                ]),
            ]);
    }
}
