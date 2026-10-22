<?php

namespace App\Filament\Resources\Translations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TranslationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('المعرّف'),
                TextEntry::make('entity_type')
                    ->label('نوع الكيان'),
                TextEntry::make('entity_id')
                    ->label('معرّف الكيان'),
                TextEntry::make('field')
                    ->label('الحقل'),
                TextEntry::make('language_code')
                    ->label('رمز اللغة'),
                TextEntry::make('value')
                    ->label('القيمة')
                    ->columnSpanFull(),
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
