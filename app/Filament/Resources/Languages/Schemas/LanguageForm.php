<?php

namespace App\Filament\Resources\Languages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LanguageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('الرمز')
                    ->required(),
                TextInput::make('name')
                    ->label('الاسم')
                    ->required(),
                TextInput::make('native_name')
                    ->label('الاسم الأصلي'),
                TextInput::make('direction')
                    ->label('اتجاه الكتابة')
                    ->required(),
                Toggle::make('is_default')
                    ->label('افتراضي')
                    ->required(),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->required()
                    ->label('نشط')
                    ->required(),
            ]);
    }
}
