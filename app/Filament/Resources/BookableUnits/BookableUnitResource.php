<?php

namespace App\Filament\Resources\BookableUnits;

use App\Filament\Resources\BookableUnits\Pages\CreateBookableUnit;
use App\Filament\Resources\BookableUnits\Pages\EditBookableUnit;
use App\Filament\Resources\BookableUnits\Pages\ListBookableUnits;
use App\Filament\Resources\BookableUnits\Pages\ViewBookableUnit;
use App\Filament\Resources\BookableUnits\Schemas\BookableUnitForm;
use App\Filament\Resources\BookableUnits\Schemas\BookableUnitInfolist;
use App\Filament\Resources\BookableUnits\Tables\BookableUnitsTable;
use App\Models\BookableUnit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookableUnitResource extends Resource
{
    protected static ?string $model = BookableUnit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|\UnitEnum|null $navigationGroup = 'العقارات والوحدات';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'وحدة قابلة للحجز';

    protected static ?string $pluralModelLabel = 'وحدات قابلة للحجز';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BookableUnitForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BookableUnitInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookableUnitsTable::configure($table);
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
            'index' => ListBookableUnits::route('/'),
            'create' => CreateBookableUnit::route('/create'),
            'view' => ViewBookableUnit::route('/{record}'),
            'edit' => EditBookableUnit::route('/{record}/edit'),
        ];
    }
}
