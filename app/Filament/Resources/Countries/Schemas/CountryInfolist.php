<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CountryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('المعرّف'),
                TextEntry::make('slug')
                    ->label('المعرّف اللطيف'),
                TextEntry::make('code')
                    ->label('رمز الدولة'),
                TextEntry::make('key')
                    ->label('مفتاح الاتصال'),
                TextEntry::make('name')
                    ->label('اسم الدولة'),
                TextEntry::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
