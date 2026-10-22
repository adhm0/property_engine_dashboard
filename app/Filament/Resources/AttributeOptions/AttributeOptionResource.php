<?php

namespace App\Filament\Resources\AttributeOptions;

use App\Filament\Resources\AttributeOptions\Pages\CreateAttributeOption;
use App\Filament\Resources\AttributeOptions\Pages\EditAttributeOption;
use App\Filament\Resources\AttributeOptions\Pages\ListAttributeOptions;
use App\Filament\Resources\AttributeOptions\Pages\ViewAttributeOption;
use App\Filament\Resources\AttributeOptions\Schemas\AttributeOptionForm;
use App\Filament\Resources\AttributeOptions\Schemas\AttributeOptionInfolist;
use App\Filament\Resources\AttributeOptions\Tables\AttributeOptionsTable;
use App\Models\AttributeOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AttributeOptionResource extends Resource
{
    protected static ?string $model = AttributeOption::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static string|\UnitEnum|null $navigationGroup = 'السمات الديناميكية';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'خيار السمة';
    protected static ?string $pluralModelLabel = 'خيارات السمات';

    protected static ?string $recordTitleAttribute = 'value';

    public static function form(Schema $schema): Schema
    {
        return AttributeOptionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AttributeOptionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttributeOptionsTable::configure($table);
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
            'index' => ListAttributeOptions::route('/'),
            'create' => CreateAttributeOption::route('/create'),
            'view' => ViewAttributeOption::route('/{record}'),
            'edit' => EditAttributeOption::route('/{record}/edit'),
        ];
    }
}
