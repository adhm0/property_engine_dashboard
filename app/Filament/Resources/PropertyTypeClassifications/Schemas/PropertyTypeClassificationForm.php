<?php

namespace App\Filament\Resources\PropertyTypeClassifications\Schemas;

use App\Models\PropertyClassification;
use App\Models\PropertyType;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PropertyTypeClassificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('النوع والتصنيف')
                    ->description('ربط نوع العقار بأحد تصنيفاته المسموح بها.')
                    ->icon('heroicon-o-tag')
                    ->columns(2)
                    ->schema([
                        Select::make('property_type_id')
                            ->label('نوع العقار')
                            ->options(
                                PropertyType::query()
                                    ->where('is_active', true)
                                    ->orderBy('code')
                                    ->pluck('code', 'id')
                                    ->map(fn ($code) => ucfirst($code))
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('اختر نوع العقار')
                            ->columnSpan(1),

                        Select::make('classification_id')
                            ->label('التصنيف')
                            ->options(
                                PropertyClassification::query()
                                    ->where('is_active', true)
                                    ->orderBy('code')
                                    ->pluck('code', 'id')
                                    ->map(fn ($code) => ucfirst($code))
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('اختر التصنيف')
                            ->columnSpan(1),
                    ]),

                Section::make('الحالة')
                    ->icon('heroicon-o-check-circle')
                    ->compact()
                    ->schema([
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->helperText('تظهر التوليفات النشطة فقط في قوائم العقارات.')
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }
}
