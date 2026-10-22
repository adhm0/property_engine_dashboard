<?php

namespace App\Filament\Resources\PropertyTypeClassifications\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PropertyTypeClassificationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('النوع والتصنيف')
                    ->icon('heroicon-o-tag')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('propertyType.code')
                            ->label('نوع العقار')
                            ->formatStateUsing(fn ($state) => ucfirst($state ?? '—'))
                            ->badge()
                            ->color('primary'),

                        TextEntry::make('propertyClassification.code')
                            ->label('التصنيف')
                            ->formatStateUsing(fn ($state) => ucfirst($state ?? '—'))
                            ->badge()
                            ->color('info'),
                    ]),

                Section::make('الحالة والتواريخ')
                    ->icon('heroicon-o-clock')
                    ->columns(3)
                    ->schema([
                        IconEntry::make('is_active')
                            ->label('نشط')
                            ->boolean(),

                        TextEntry::make('created_at')
                            ->label('تاريخ الإنشاء')
                            ->dateTime()
                            ->placeholder('—'),

                        TextEntry::make('updated_at')
                            ->label('تاريخ التحديث')
                            ->dateTime()
                            ->placeholder('—'),
                    ]),
            ]);
    }
}

