<?php

namespace App\Filament\Resources\AttributeGroups\Schemas;

use App\Filament\Support\TranslationFields;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AttributeGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('الرمز')
                    ->required(),
                TextInput::make('icon')
                    ->label('الأيقونة'),
                TextInput::make('display_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->required()
                    ->label('نشط')
                    ->required(),

                TranslationFields::make([
                    'code' => ['label' => 'اسم المجموعة', 'maxLength' => 80],
                ]),
            ]);
    }
}
