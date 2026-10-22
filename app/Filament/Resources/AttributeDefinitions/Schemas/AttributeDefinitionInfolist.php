<?php

namespace App\Filament\Resources\AttributeDefinitions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AttributeDefinitionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('المعرّف'),
                TextEntry::make('key')
                    ->label('المفتاح'),
                TextEntry::make('value_type')
                    ->label('نوع القيمة'),
                TextEntry::make('group_id')
                    ->label('مجموعة السمة'),
                TextEntry::make('icon')
                    ->label('الأيقونة')
                    ->placeholder('-'),
                TextEntry::make('unit_code')
                    ->label('وحدة القياس')
                    ->placeholder('-'),
                IconEntry::make('is_required')
                    ->label('مطلوبة')
                    ->boolean(),
                IconEntry::make('is_filterable')
                    ->label('قابلة للفلترة')
                    ->boolean(),
                IconEntry::make('is_searchable')
                    ->label('قابلة للبحث')
                    ->boolean(),
                IconEntry::make('is_displayable')
                    ->label('تظهر في القائمة')
                    ->boolean(),
                TextEntry::make('display_order')
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
