<?php

namespace App\Filament\Resources\BookableUnits\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookableUnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم الوحدة')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('property.name')
                    ->label('العقار')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('unitType.code')
                    ->label('نوع الوحدة')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('capacity')
                    ->label('السعة')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('base_price')
                    ->label('السعر الأساسي')
                    ->prefix('$')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('offer_price')
                    ->label('سعر العرض')
                    ->prefix('$')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->placeholder('لا يوجد'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ACTIVE' => 'success',
                        'INACTIVE' => 'gray',
                        'MAINTENANCE' => 'warning',
                        'BOOKED' => 'info',
                        default => 'primary',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'ACTIVE' => 'نشط',
                        'INACTIVE' => 'غير نشط',
                        'MAINTENANCE' => 'قيد الصيانة',
                        'BOOKED' => 'محجوز',
                    ]),
                SelectFilter::make('property')
                    ->relationship('property', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('unitType')
                    ->relationship('unitType', 'code')
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
