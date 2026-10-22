<?php

namespace Database\Seeders;

use App\Models\UnitTypeAttribute;
use App\Models\BookableUnitType;
use App\Models\AttributeDefinition;
use Illuminate\Database\Seeder;

class UnitTypeAttributeSeeder extends Seeder
{
    public function run(): void
    {
        $suite = BookableUnitType::where('code', 'suite')->first();
        $bedrooms = AttributeDefinition::where('key', 'bedrooms')->first();
        $bathrooms = AttributeDefinition::where('key', 'bathrooms')->first();
        $area_m2 = AttributeDefinition::where('key', 'area_m2')->first();
        $has_pool = AttributeDefinition::where('key', 'has_pool')->first();

        UnitTypeAttribute::create([
            'unit_type_id' => $suite->id,
            'attribute_id' => $bedrooms->id,
            'is_required' => true,
            'is_filterable' => true,
            'is_displayable' => true,
            'sort_order' => 0,
        ]);

        UnitTypeAttribute::create([
            'unit_type_id' => $suite->id,
            'attribute_id' => $bathrooms->id,
            'is_required' => true,
            'is_filterable' => true,
            'is_displayable' => true,
            'sort_order' => 1,
        ]);

        UnitTypeAttribute::create([
            'unit_type_id' => $suite->id,
            'attribute_id' => $area_m2->id,
            'is_required' => false,
            'is_filterable' => false,
            'is_displayable' => true,
            'sort_order' => 2,
        ]);

        UnitTypeAttribute::create([
            'unit_type_id' => $suite->id,
            'attribute_id' => $has_pool->id,
            'is_required' => true,
            'is_filterable' => true,
            'is_displayable' => true,
            'sort_order' => 3,
        ]);
    }
}
