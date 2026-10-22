<?php

namespace App\Filament\Resources\Properties\Schemas;

use App\Filament\Support\TranslationFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('نظرة عامة على العقار')
                    ->description('التفاصيل الأساسية للعقار والملكية')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('اسم العقار')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('مثال: شاليه صن سيت الفاخر'),
                                Select::make('status')
                                    ->label('الحالة')
                                    ->options([
                                        'PENDING' => 'قيد المراجعة',
                                        'ACTIVE' => 'نشط',
                                        'INACTIVE' => 'غير نشط',
                                        'SUSPENDED' => 'موقوف',
                                    ])
                                    ->default('PENDING')
                                    ->required()
                                    ->native(false),
                                Select::make('owner_id')
                                    ->relationship('owner', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('المالك'),
                                Select::make('property_type_classification_id')
                                    ->relationship('typeClassification', 'id')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->display_name)
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('نوع العقار والتصنيف'),
                            ]),
                        Textarea::make('description')
                            ->label('الوصف')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('صف العقار والأجواء والمرافق وما إلى ذلك.'),
                    ]),

                Section::make('الموقع والجغرافيا')
                    ->description('الموقع الجغرافي وتفاصيل العنوان')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('district_id')
                                    ->relationship('district', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('الحي'),
                                TextInput::make('postal_code')
                                    ->label('الرمز البريدي'),
                                TextInput::make('address_line1')
                                    ->label('العنوان - السطر الأول'),
                                TextInput::make('address_line2')
                                    ->label('العنوان - السطر الثاني'),
                                TextInput::make('landmark')
                                    ->label('معلم قريب / نقاط مرجعية')
                                    ->columnSpanFull(),
                                TextInput::make('latitude')
                                    ->numeric()
                                    ->step('any')
                                    ->label('خط العرض'),
                                TextInput::make('longitude')
                                    ->numeric()
                                    ->step('any')
                                    ->label('خط الطول'),
                            ]),
                    ]),

                TranslationFields::make([
                    'name' => ['label' => 'اسم العقار', 'maxLength' => 200],
                    'description' => ['label' => 'وصف العقار', 'type' => 'textarea', 'rows' => 4],
                ]),
            ]);
    }
}
