<?php

namespace App\Filament\Resources\BookableUnitAttributeValues;

use App\Filament\Resources\BookableUnitAttributeValues\Pages\CreateBookableUnitAttributeValue;
use App\Filament\Resources\BookableUnitAttributeValues\Pages\EditBookableUnitAttributeValue;
use App\Filament\Resources\BookableUnitAttributeValues\Pages\ListBookableUnitAttributeValues;
use App\Filament\Resources\BookableUnitAttributeValues\Pages\ViewBookableUnitAttributeValue;
use App\Filament\Resources\BookableUnitAttributeValues\Schemas\BookableUnitAttributeValueForm;
use App\Filament\Resources\BookableUnitAttributeValues\Schemas\BookableUnitAttributeValueInfolist;
use App\Filament\Resources\BookableUnitAttributeValues\Tables\BookableUnitAttributeValuesTable;
use App\Models\BookableUnitAttributeValue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookableUnitAttributeValueResource extends Resource
{
    protected static ?string $model = BookableUnitAttributeValue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVariable;

    protected static string|\UnitEnum|null $navigationGroup = 'السمات الديناميكية';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'قيمة سمة الوحدة';

    protected static ?string $pluralModelLabel = 'قيم سمات الوحدات';

    public static function form(Schema $schema): Schema
    {
        return BookableUnitAttributeValueForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BookableUnitAttributeValueInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookableUnitAttributeValuesTable::configure($table);
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
            'index' => ListBookableUnitAttributeValues::route('/'),
            'create' => CreateBookableUnitAttributeValue::route('/create'),
            'view' => ViewBookableUnitAttributeValue::route('/{record}'),
            'edit' => EditBookableUnitAttributeValue::route('/{record}/edit'),
        ];
    }
}
