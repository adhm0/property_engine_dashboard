<?php

namespace App\Filament\Resources\Districts\Schemas;

use App\Filament\Support\TranslationFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DistrictForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('city_id')
                    ->relationship('city', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('المدينة'),
                TextInput::make('name')
                    ->label('اسم الحي')
                    ->required()
                    ->maxLength(100),
                TextInput::make('slug')
                    ->label('المعرّف اللطيف')
                    ->required()
                    ->maxLength(100),

                TranslationFields::make([
                    'name' => ['label' => 'اسم الحي', 'maxLength' => 120],
                ]),
            ]);
    }
}
