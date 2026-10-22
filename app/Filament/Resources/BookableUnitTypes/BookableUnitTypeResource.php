<?php

namespace App\Filament\Resources\BookableUnitTypes;

use App\Filament\Resources\BookableUnitTypes\Pages\CreateBookableUnitType;
use App\Filament\Resources\BookableUnitTypes\Pages\EditBookableUnitType;
use App\Filament\Resources\BookableUnitTypes\Pages\ListBookableUnitTypes;
use App\Filament\Resources\BookableUnitTypes\Pages\ViewBookableUnitType;
use App\Filament\Resources\BookableUnitTypes\Schemas\BookableUnitTypeForm;
use App\Filament\Resources\BookableUnitTypes\Schemas\BookableUnitTypeInfolist;
use App\Filament\Resources\BookableUnitTypes\Tables\BookableUnitTypesTable;
use App\Models\BookableUnitType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookableUnitTypeResource extends Resource
{
    protected static ?string $model = BookableUnitType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|\UnitEnum|null $navigationGroup = 'العقارات والوحدات';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'نوع الوحدة';
    protected static ?string $pluralModelLabel = 'أنواع الوحدات';

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return BookableUnitTypeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BookableUnitTypeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookableUnitTypesTable::configure($table);
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
            'index' => ListBookableUnitTypes::route('/'),
            'create' => CreateBookableUnitType::route('/create'),
            'view' => ViewBookableUnitType::route('/{record}'),
            'edit' => EditBookableUnitType::route('/{record}/edit'),
        ];
    }
}
