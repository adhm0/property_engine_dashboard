<?php

namespace App\Filament\Resources\UnitTypeAttributes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UnitTypeAttributesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unitType.code')
                    ->label('نوع الوحدة')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('attribute.key')
                    ->label('السمة')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_required')
                    ->label('مطلوبة')
                    ->boolean(),
                IconColumn::make('is_filterable')
                    ->label('قابلة للفلترة')
                    ->boolean(),
                IconColumn::make('is_displayable')
                    ->label('تظهر في الواجهة')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label('ترتيب العرض')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
