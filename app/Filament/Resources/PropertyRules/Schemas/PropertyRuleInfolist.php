<?php

namespace App\Filament\Resources\PropertyRules\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PropertyRuleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('المعرّف'),
                TextEntry::make('property.name')
                    ->label('العقار'),
                TextEntry::make('code')
                    ->label('الرمز'),
                TextEntry::make('type')
                    ->label('النوع'),
                TextEntry::make('icon')
                    ->label('الأيقونة')
                    ->placeholder('-'),
                TextEntry::make('sort_order')
                    ->label('ترتيب العرض')
                    ->numeric(),
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
