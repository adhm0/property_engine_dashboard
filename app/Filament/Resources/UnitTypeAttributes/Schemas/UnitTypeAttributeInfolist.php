<?php

namespace App\Filament\Resources\UnitTypeAttributes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UnitTypeAttributeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('المعرّف'),
                TextEntry::make('unit_type_id')
                    ->label('نوع الوحدة'),
                TextEntry::make('attribute_id')
                    ->label('معرّف السمة'),
                IconEntry::make('is_required')
                    ->label('مطلوبة')
                    ->boolean(),
                IconEntry::make('is_filterable')
                    ->label('قابلة للفلترة')
                    ->boolean(),
                IconEntry::make('is_displayable')
                    ->label('تظهر في القائمة')
                    ->boolean(),
                TextEntry::make('sort_order')
                    ->label('ترتيب العرض')
                    ->numeric(),
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
