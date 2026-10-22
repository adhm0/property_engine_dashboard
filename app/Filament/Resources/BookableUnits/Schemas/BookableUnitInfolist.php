<?php

namespace App\Filament\Resources\BookableUnits\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookableUnitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل الوحدة')
                    ->schema([
                        TextEntry::make('name')
                            ->label('اسم الوحدة'),
                        TextEntry::make('property.name')
                            ->label('العقار'),
                        TextEntry::make('unitType.code')
                            ->label('نوع الوحدة')
                            ->badge(),
                        TextEntry::make('capacity')
                            ->label('السعة')
                            ->numeric(),
                        TextEntry::make('base_price')
                            ->label('السعر الأساسي')
                            ->prefix('$')
                            ->numeric(decimalPlaces: 2),
                        TextEntry::make('offer_price')
                            ->label('سعر العرض')
                            ->prefix('$')
                            ->numeric(decimalPlaces: 2)
                            ->placeholder('-'),
                        TextEntry::make('status')
                            ->label('الحالة')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'ACTIVE' => 'success',
                                'INACTIVE' => 'gray',
                                'MAINTENANCE' => 'warning',
                                'BOOKED' => 'info',
                                default => 'primary',
                            }),
                        TextEntry::make('filter_attributes')
                            ->label('بيانات الفلترة')
                            ->placeholder('-')
                            ->formatStateUsing(fn (?array $state): ?string => filled($state)
                                ? collect($state)
                                    ->map(fn ($value, $key): string => $key.': '.match (true) {
                                        is_bool($value) => $value ? 'نعم' : 'لا',
                                        is_array($value) => json_encode($value, JSON_UNESCAPED_UNICODE),
                                        default => (string) $value,
                                    })
                                    ->implode(' | ')
                                : null)
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->label('تاريخ الإنشاء')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('تاريخ التحديث')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }
}
