<?php

namespace App\Filament\Resources\Cities\Schemas;

use App\Filament\Support\TranslationFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('country_id')
                    ->relationship('country', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('الدولة'),
                TextInput::make('name')
                    ->label('اسم المدينة')
                    ->required()
                    ->maxLength(100),
                TextInput::make('slug')
                    ->label('المعرّف اللطيف')
                    ->required()
                    ->maxLength(100),

                TranslationFields::make([
                    'name' => ['label' => 'اسم المدينة', 'maxLength' => 120],
                ]),
            ]);
    }
}
