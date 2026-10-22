<?php

namespace App\Filament\Resources\PropertyClassifications;

use App\Filament\Resources\PropertyClassifications\Pages\CreatePropertyClassification;
use App\Filament\Resources\PropertyClassifications\Pages\EditPropertyClassification;
use App\Filament\Resources\PropertyClassifications\Pages\ListPropertyClassifications;
use App\Filament\Resources\PropertyClassifications\Pages\ViewPropertyClassification;
use App\Filament\Resources\PropertyClassifications\Schemas\PropertyClassificationForm;
use App\Filament\Resources\PropertyClassifications\Schemas\PropertyClassificationInfolist;
use App\Filament\Resources\PropertyClassifications\Tables\PropertyClassificationsTable;
use App\Models\PropertyClassification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PropertyClassificationResource extends Resource
{
    protected static ?string $model = PropertyClassification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmark;

    protected static string|\UnitEnum|null $navigationGroup = 'التصنيف والتبويب';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'تصنيف العقار';
    protected static ?string $pluralModelLabel = 'تصنيفات العقارات';

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return PropertyClassificationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PropertyClassificationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PropertyClassificationsTable::configure($table);
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
            'index' => ListPropertyClassifications::route('/'),
            'create' => CreatePropertyClassification::route('/create'),
            'view' => ViewPropertyClassification::route('/{record}'),
            'edit' => EditPropertyClassification::route('/{record}/edit'),
        ];
    }
}
