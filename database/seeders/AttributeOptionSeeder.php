<?php

namespace Database\Seeders;

use App\Models\AttributeDefinition;
use App\Models\AttributeOption;
use Illuminate\Database\Seeder;

class AttributeOptionSeeder extends Seeder
{
    public function run(): void
    {
        $viewAttribute = AttributeDefinition::where('key', 'view')->first();

        AttributeOption::create([
            'attribute_id' => $viewAttribute->id,
            'value' => 'sea_view',
            'icon' => 'water',
            'sort_order' => 0,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['value' => 'إطلالة على البحر'],
                'en' => ['value' => 'Sea View'],
            ],
        ]);

        AttributeOption::create([
            'attribute_id' => $viewAttribute->id,
            'value' => 'city_view',
            'icon' => 'location_city',
            'sort_order' => 1,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['value' => 'إطلالة على المدينة'],
                'en' => ['value' => 'City View'],
            ],
        ]);

        AttributeOption::create([
            'attribute_id' => $viewAttribute->id,
            'value' => 'garden_view',
            'icon' => 'park',
            'sort_order' => 2,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['value' => 'إطلالة على الحديقة'],
                'en' => ['value' => 'Garden View'],
            ],
        ]);

        AttributeOption::create([
            'attribute_id' => $viewAttribute->id,
            'value' => 'mountain_view',
            'icon' => 'terrain',
            'sort_order' => 3,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['value' => 'إطلالة على الجبال'],
                'en' => ['value' => 'Mountain View'],
            ],
        ]);
    }
}
