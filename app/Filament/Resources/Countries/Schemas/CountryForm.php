<?php

namespace App\Filament\Resources\Countries\Schemas;

use App\Filament\Support\TranslationFields;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->label('المعرّف اللطيف')
                    ->required(),
                TextInput::make('code')
                    ->label('رمز الدولة')
                    ->required(),
                TextInput::make('key')
                    ->label('مفتاح الاتصال')
                    ->required(),
                TextInput::make('name')
                    ->label('اسم الدولة')
                    ->required(),

                TranslationFields::make([
                    'name' => ['label' => 'اسم الدولة', 'maxLength' => 120],
                ]),
            ]);
    }
}
