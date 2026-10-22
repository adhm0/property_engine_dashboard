<?php

namespace App\Filament\Resources\Languages\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LanguageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('المعرّف'),
                TextEntry::make('code')
                    ->label('الرمز'),
                TextEntry::make('name')
                    ->label('الاسم'),
                TextEntry::make('native_name')
                    ->label('الاسم الأصلي')
                    ->placeholder('-'),
                TextEntry::make('direction')
                    ->label('اتجاه الكتابة'),
                IconEntry::make('is_default')
                    ->label('افتراضي')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->label('نشط')
                    ->boolean(),
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
