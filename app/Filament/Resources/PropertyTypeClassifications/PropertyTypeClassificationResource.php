<?php

namespace App\Filament\Resources\PropertyTypeClassifications;

use App\Filament\Resources\PropertyTypeClassifications\Pages\CreatePropertyTypeClassification;
use App\Filament\Resources\PropertyTypeClassifications\Pages\EditPropertyTypeClassification;
use App\Filament\Resources\PropertyTypeClassifications\Pages\ListPropertyTypeClassifications;
use App\Filament\Resources\PropertyTypeClassifications\Pages\ViewPropertyTypeClassification;
use App\Filament\Resources\PropertyTypeClassifications\Schemas\PropertyTypeClassificationForm;
use App\Filament\Resources\PropertyTypeClassifications\Schemas\PropertyTypeClassificationInfolist;
use App\Filament\Resources\PropertyTypeClassifications\Tables\PropertyTypeClassificationsTable;
use App\Models\PropertyTypeClassification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PropertyTypeClassificationResource extends Resource
{
    protected static ?string $model = PropertyTypeClassification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'التصنيف والتبويب';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'ربط نوع العقار بالتصنيف';
    protected static ?string $pluralModelLabel = 'روابط النوع والتصنيف';

    public static function form(Schema $schema): Schema
    {
        return PropertyTypeClassificationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PropertyTypeClassificationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PropertyTypeClassificationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPropertyTypeClassifications::route('/'),
            'create' => CreatePropertyTypeClassification::route('/create'),
            'view' => ViewPropertyTypeClassification::route('/{record}'),
            'edit' => EditPropertyTypeClassification::route('/{record}/edit'),
        ];
    }
}
