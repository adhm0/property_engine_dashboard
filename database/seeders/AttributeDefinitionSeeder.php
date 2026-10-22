<?php

namespace Database\Seeders;

use App\Models\AttributeDefinition;
use App\Models\AttributeGroup;
use Illuminate\Database\Seeder;

class AttributeDefinitionSeeder extends Seeder
{
    public function run(): void
    {
        $basic = AttributeGroup::where('code', 'basic')->first();
        $amenities = AttributeGroup::where('code', 'amenities')->first();

        AttributeDefinition::create([
            'key' => 'bedrooms',
            'value_type' => 'NUMBER',
            'group_id' => $basic->id,
            'icon' => 'bed',
            'unit_code' => 'room',
            'is_required' => true,
            'is_filterable' => true,
            'is_searchable' => true,
            'is_displayable' => true,
            'display_order' => 0,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['key' => 'غرف النوم'],
                'en' => ['key' => 'Bedrooms'],
            ],
        ]);

        AttributeDefinition::create([
            'key' => 'bathrooms',
            'value_type' => 'NUMBER',
            'group_id' => $basic->id,
            'icon' => 'bath',
            'unit_code' => 'room',
            'is_required' => true,
            'is_filterable' => true,
            'is_searchable' => true,
            'is_displayable' => true,
            'display_order' => 1,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['key' => 'الحمامات'],
                'en' => ['key' => 'Bathrooms'],
            ],
        ]);

        AttributeDefinition::create([
            'key' => 'area_m2',
            'value_type' => 'NUMBER',
            'group_id' => $basic->id,
            'icon' => 'expand',
            'unit_code' => 'm2',
            'is_required' => false,
            'is_filterable' => false,
            'is_searchable' => true,
            'is_displayable' => true,
            'display_order' => 2,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['key' => 'المساحة (م²)'],
                'en' => ['key' => 'Area (m²)'],
            ],
        ]);

        AttributeDefinition::create([
            'key' => 'has_pool',
            'value_type' => 'BOOLEAN',
            'group_id' => $amenities->id,
            'icon' => 'pool',
            'is_required' => false,
            'is_filterable' => true,
            'is_searchable' => true,
            'is_displayable' => true,
            'display_order' => 0,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['key' => 'مسبح'],
                'en' => ['key' => 'Pool'],
            ],
        ]);

        AttributeDefinition::create([
            'key' => 'has_wifi',
            'value_type' => 'BOOLEAN',
            'group_id' => $amenities->id,
            'icon' => 'wifi',
            'is_required' => false,
            'is_filterable' => true,
            'is_searchable' => true,
            'is_displayable' => true,
            'display_order' => 1,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['key' => 'واي فاي'],
                'en' => ['key' => 'Wi-Fi'],
            ],
        ]);

        AttributeDefinition::create([
            'key' => 'view',
            'value_type' => 'ENUM',
            'group_id' => $amenities->id,
            'icon' => 'visibility',
            'is_required' => false,
            'is_filterable' => true,
            'is_searchable' => true,
            'is_displayable' => true,
            'display_order' => 2,
            'is_active' => true,
            'translations_data' => [
                'ar' => ['key' => 'الإطلالة'],
                'en' => ['key' => 'View'],
            ],
        ]);
    }
}
