<?php

namespace App\Filament\Resources\AttributeDefinitions;

use App\Filament\Resources\AttributeDefinitions\Pages\CreateAttributeDefinition;
use App\Filament\Resources\AttributeDefinitions\Pages\EditAttributeDefinition;
use App\Filament\Resources\AttributeDefinitions\Pages\ListAttributeDefinitions;
use App\Filament\Resources\AttributeDefinitions\Pages\ViewAttributeDefinition;
use App\Filament\Resources\AttributeDefinitions\Schemas\AttributeDefinitionForm;
use App\Filament\Resources\AttributeDefinitions\Schemas\AttributeDefinitionInfolist;
use App\Filament\Resources\AttributeDefinitions\Tables\AttributeDefinitionsTable;
use App\Models\AttributeDefinition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AttributeDefinitionResource extends Resource
{
    protected static ?string $model = AttributeDefinition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static string|\UnitEnum|null $navigationGroup = 'السمات الديناميكية';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'تعريف السمة';
    protected static ?string $pluralModelLabel = 'تعريفات السمات';

    protected static ?string $recordTitleAttribute = 'key';

    public static function form(Schema $schema): Schema
    {
        return AttributeDefinitionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AttributeDefinitionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttributeDefinitionsTable::configure($table);
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
            'index' => ListAttributeDefinitions::route('/'),
            'create' => CreateAttributeDefinition::route('/create'),
            'view' => ViewAttributeDefinition::route('/{record}'),
            'edit' => EditAttributeDefinition::route('/{record}/edit'),
        ];
    }
}
