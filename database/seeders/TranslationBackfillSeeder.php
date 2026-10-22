<?php

namespace Database\Seeders;

use App\Models\AttributeDefinition;
use App\Models\AttributeGroup;
use App\Models\AttributeOption;
use App\Models\BookableUnit;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Property;
use App\Models\PropertyRule;
use Illuminate\Database\Seeder;

class TranslationBackfillSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            Country::class,
            City::class,
            District::class,
            Property::class,
            BookableUnit::class,
            PropertyRule::class,
            AttributeGroup::class,
            AttributeDefinition::class,
            AttributeOption::class,
        ];

        foreach ($models as $model) {
            $model::query()->each(fn ($record) => $record->syncTranslations());
        }
    }
}
