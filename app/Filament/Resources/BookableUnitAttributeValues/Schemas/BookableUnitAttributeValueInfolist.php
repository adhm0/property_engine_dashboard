<?php

namespace App\Filament\Resources\BookableUnitAttributeValues\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookableUnitAttributeValueInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('المعرّف'),
                TextEntry::make('unit_id'),
                TextEntry::make('attribute_id')
                    ->label('معرّف السمة'),
                TextEntry::make('value_string')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('value_number')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('value_boolean')
                    ->boolean()
                    ->placeholder('-'),
                TextEntry::make('value_date')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('option_id')
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
