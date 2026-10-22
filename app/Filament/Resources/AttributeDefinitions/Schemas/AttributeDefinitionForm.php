<?php

namespace App\Filament\Resources\AttributeDefinitions\Schemas;

use App\Filament\Support\TranslationFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AttributeDefinitionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('مواصفات السمة')
                    ->description('تعريف نوع البيانات والتجميع لقيم EAV الديناميكية')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('key')
                                    ->label('المفتاح')
                                    ->required()
                                    ->maxLength(80)
                                    ->placeholder('مثال: pool_type, wifi_speed'),
                                Select::make('value_type')
                                    ->label('نوع القيمة')
                                    ->options([
                                        'TEXT' => 'نص (سلسلة نصية)',
                                        'NUMBER' => 'رقمي (صحيح / عشري)',
                                        'BOOLEAN' => 'منطقي (نعم / لا)',
                                        'ENUM' => 'قائمة (خيارات محددة مسبقاً)',
                                        'DATE' => 'تاريخ / وقت',
                                        'JSON' => 'JSON منظم',
                                    ])
                                    ->required()
                                    ->native(false),
                                Select::make('group_id')
                                    ->relationship('group', 'code')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('مجموعة السمة'),
                                TextInput::make('unit_code')
                                    ->maxLength(30)
                                    ->placeholder('مثال: متر مربع، Mbps، كجم')
                                    ->label('وحدة القياس'),
                                TextInput::make('icon')
                                    ->placeholder('مثال: heroicon-o-wifi')
                                    ->label('معرّف الأيقونة'),
                                TextInput::make('display_order')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->label('ترتيب العرض'),
                            ]),
                    ]),

                Section::make('السلوك والإعدادات')
                    ->description('التحكم في كيفية ظهور هذه السمة في البحث والفلاتر والنماذج')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_active')
                                    ->default(true)
                                    ->label('نشطة'),
                                Toggle::make('is_required')
                                    ->default(false)
                                    ->label('مطلوبة'),
                                Toggle::make('is_filterable')
                                    ->default(false)
                                    ->label('قابلة للفلترة'),
                                Toggle::make('is_searchable')
                                    ->default(false)
                                    ->label('قابلة للبحث'),
                                Toggle::make('is_displayable')
                                    ->default(true)
                                    ->label('تظهر في القائمة'),
                            ]),
                    ]),

                TranslationFields::make([
                    'key' => ['label' => 'اسم السمة', 'maxLength' => 80],
                ]),
            ]);
    }
}
