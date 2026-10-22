<?php

namespace App\Filament\Resources\Properties\RelationManagers;

use App\Filament\Support\TranslationFields;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RulesRelationManager extends RelationManager
{
    protected static string $relationship = 'rules';

    protected static ?string $title = 'قواعد العقار';

    protected static ?string $modelLabel = 'قاعدة';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('الرمز')
                    ->required()
                    ->maxLength(80),
                Select::make('type')
                    ->label('النوع')
                    ->options([
                        'TEXT' => 'نص',
                        'BOOLEAN' => 'نعم / لا',
                        'TIME' => 'وقت',
                        'MONEY' => 'مبلغ مالي',
                    ])
                    ->required()
                    ->native(false),
                TextInput::make('icon')
                    ->label('الأيقونة'),
                TextInput::make('sort_order')
                    ->label('ترتيب العرض')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true),

                TranslationFields::make([
                    'code' => ['label' => 'نص القاعدة', 'maxLength' => 80],
                ]),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('الرمز')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('النوع')
                    ->searchable(),
                TextColumn::make('icon')
                    ->label('الأيقونة'),
                TextColumn::make('sort_order')
                    ->label('ترتيب العرض')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
