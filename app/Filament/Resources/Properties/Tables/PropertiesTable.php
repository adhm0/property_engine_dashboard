<?php

namespace App\Filament\Resources\Properties\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PropertiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم العقار')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ACTIVE' => 'success',
                        'PENDING' => 'warning',
                        'INACTIVE' => 'gray',
                        'SUSPENDED' => 'danger',
                        default => 'primary',
                    })
                    ->sortable(),
                TextColumn::make('owner.name')
                    ->label('المالك')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('district.name')
                    ->label('الحي')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('district.city.name')
                    ->label('المدينة')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bookable_units_count')
                    ->counts('bookableUnits')
                    ->label('عدد الوحدات')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('landmark')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('postal_code')
                    ->label('الرمز البريدي')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'PENDING' => 'قيد المراجعة',
                        'ACTIVE' => 'نشط',
                        'INACTIVE' => 'غير نشط',
                        'SUSPENDED' => 'موقوف',
                    ]),
                SelectFilter::make('district')
                    ->relationship('district', 'name')
                    ->searchable()
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
