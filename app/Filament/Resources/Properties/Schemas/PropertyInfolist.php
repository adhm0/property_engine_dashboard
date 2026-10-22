<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PropertyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('المعرّف'),
                TextEntry::make('owner_id')
                    ->label('المالك'),
                TextEntry::make('property_type_classification_id')
                    ->label('نوع العقار والتصنيف'),
                TextEntry::make('district_id')
                    ->label('الحي'),
                TextEntry::make('name')
                    ->label('الاسم'),
                TextEntry::make('description')
                    ->label('الوصف')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->label('الحالة'),
                TextEntry::make('address_line1')
                    ->label('العنوان - السطر الأول')
                    ->placeholder('-'),
                TextEntry::make('address_line2')
                    ->label('العنوان - السطر الثاني')
                    ->placeholder('-'),
                TextEntry::make('landmark')
                    ->label('معلم قريب')
                    ->placeholder('-'),
                TextEntry::make('postal_code')
                    ->label('الرمز البريدي')
                    ->placeholder('-'),
                TextEntry::make('latitude')
                    ->label('خط العرض')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('longitude')
                    ->label('خط الطول')
                    ->numeric()
                    ->placeholder('-'),
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
