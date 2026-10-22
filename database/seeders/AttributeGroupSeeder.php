<?php

namespace Database\Seeders;

use App\Models\AttributeGroup;
use Illuminate\Database\Seeder;

class AttributeGroupSeeder extends Seeder
{
    public function run(): void
    {
        AttributeGroup::create([
            'code' => 'basic',
            'icon' => 'home',
            'display_order' => 0,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['code' => 'أساسي'],
                'en' => ['code' => 'Basic'],
            ],
        ]);

        AttributeGroup::create([
            'code' => 'amenities',
            'icon' => 'star',
            'display_order' => 1,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['code' => 'وسائل الراحة'],
                'en' => ['code' => 'Amenities'],
            ],
        ]);

        AttributeGroup::create([
            'code' => 'rules',
            'icon' => 'gavel',
            'display_order' => 2,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['code' => 'القواعد'],
                'en' => ['code' => 'Rules'],
            ],
        ]);

        AttributeGroup::create([
            'code' => 'pricing',
            'icon' => 'cash',
            'display_order' => 3,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['code' => 'التسعير'],
                'en' => ['code' => 'Pricing'],
            ],
        ]);
    }
}
