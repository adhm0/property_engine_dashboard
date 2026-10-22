<?php

namespace App\Filament\Resources\Translations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TranslationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('entity_type')
                    ->label('نوع الكيان')
                    ->required(),
                TextInput::make('entity_id')
                    ->label('معرّف الكيان')
                    ->required(),
                TextInput::make('field')
                    ->label('الحقل')
                    ->required(),
                TextInput::make('language_code')
                    ->label('رمز اللغة')
                    ->required(),
                Textarea::make('value')
                    ->label('القيمة')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
