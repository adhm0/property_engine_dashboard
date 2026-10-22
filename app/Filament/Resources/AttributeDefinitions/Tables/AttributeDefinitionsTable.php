<?php

namespace App\Filament\Resources\AttributeDefinitions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AttributeDefinitionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('مفتاح السمة')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('group.code')
                    ->label('المجموعة')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('value_type')
                    ->label('نوع القيمة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'TEXT' => 'gray',
                        'NUMBER' => 'info',
                        'BOOLEAN' => 'warning',
                        'ENUM' => 'success',
                        'DATE' => 'primary',
                        'JSON' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('unit_code')
                    ->label('وحدة القياس')
                    ->placeholder('-'),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_filterable')
                    ->label('قابلة للفلترة')
                    ->boolean(),
                IconColumn::make('is_searchable')
                    ->label('قابلة للبحث')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('display_order')
                    ->label('الترتيب')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->relationship('group', 'code')
                    ->preload(),
                SelectFilter::make('value_type')
                    ->options([
                        'TEXT' => 'Text',
                        'NUMBER' => 'Number',
                        'BOOLEAN' => 'Boolean',
                        'ENUM' => 'Enum',
                        'DATE' => 'Date',
                        'JSON' => 'JSON',
                    ]),
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
