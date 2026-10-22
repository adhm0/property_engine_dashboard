<?php

namespace App\Filament\Resources\UnitTypeAttributes;

use App\Filament\Resources\UnitTypeAttributes\Pages\CreateUnitTypeAttribute;
use App\Filament\Resources\UnitTypeAttributes\Pages\EditUnitTypeAttribute;
use App\Filament\Resources\UnitTypeAttributes\Pages\ListUnitTypeAttributes;
use App\Filament\Resources\UnitTypeAttributes\Pages\ViewUnitTypeAttribute;
use App\Filament\Resources\UnitTypeAttributes\Schemas\UnitTypeAttributeForm;
use App\Filament\Resources\UnitTypeAttributes\Schemas\UnitTypeAttributeInfolist;
use App\Filament\Resources\UnitTypeAttributes\Tables\UnitTypeAttributesTable;
use App\Models\UnitTypeAttribute;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UnitTypeAttributeResource extends Resource
{
    protected static ?string $model = UnitTypeAttribute::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLink;

    protected static string|\UnitEnum|null $navigationGroup = 'السمات الديناميكية';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'سمة نوع الوحدة';

    protected static ?string $pluralModelLabel = 'سمات أنواع الوحدات';

    public static function form(Schema $schema): Schema
    {
        return UnitTypeAttributeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UnitTypeAttributeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnitTypeAttributesTable::configure($table);
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
            'index' => ListUnitTypeAttributes::route('/'),
            'create' => CreateUnitTypeAttribute::route('/create'),
            'view' => ViewUnitTypeAttribute::route('/{record}'),
            'edit' => EditUnitTypeAttribute::route('/{record}/edit'),
        ];
    }
}
