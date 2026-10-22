<?php

namespace App\Filament\Resources\PropertyRules;

use App\Filament\Resources\PropertyRules\Pages\CreatePropertyRule;
use App\Filament\Resources\PropertyRules\Pages\EditPropertyRule;
use App\Filament\Resources\PropertyRules\Pages\ListPropertyRules;
use App\Filament\Resources\PropertyRules\Pages\ViewPropertyRule;
use App\Filament\Resources\PropertyRules\Schemas\PropertyRuleForm;
use App\Filament\Resources\PropertyRules\Schemas\PropertyRuleInfolist;
use App\Filament\Resources\PropertyRules\Tables\PropertyRulesTable;
use App\Models\PropertyRule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PropertyRuleResource extends Resource
{
    protected static ?string $model = PropertyRule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'العقارات والوحدات';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'قاعدة العقار';
    protected static ?string $pluralModelLabel = 'قواعد العقارات';

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return PropertyRuleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PropertyRuleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PropertyRulesTable::configure($table);
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
            'index' => ListPropertyRules::route('/'),
            'create' => CreatePropertyRule::route('/create'),
            'view' => ViewPropertyRule::route('/{record}'),
            'edit' => EditPropertyRule::route('/{record}/edit'),
        ];
    }
}
