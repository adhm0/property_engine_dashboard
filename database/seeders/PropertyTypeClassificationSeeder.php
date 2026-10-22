<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use App\Models\PropertyClassification;
use App\Models\PropertyTypeClassification;
use Illuminate\Database\Seeder;

class PropertyTypeClassificationSeeder extends Seeder
{
    public function run(): void
    {
        $hotel = PropertyType::where('code', 'hotel')->first();
        $apartment = PropertyType::where('code', 'apartment')->first();
        $chalet = PropertyType::where('code', 'chalet')->first();

        $standard = PropertyClassification::where('code', 'standard')->first();
        $premium = PropertyClassification::where('code', 'premium')->first();
        $luxury = PropertyClassification::where('code', 'luxury')->first();

        PropertyTypeClassification::create([
            'property_type_id' => $hotel->id,
            'classification_id' => $standard->id,
            'is_active' => true,
        ]);

        PropertyTypeClassification::create([
            'property_type_id' => $apartment->id,
            'classification_id' => $premium->id,
            'is_active' => true,
        ]);

        PropertyTypeClassification::create([
            'property_type_id' => $chalet->id,
            'classification_id' => $luxury->id,
            'is_active' => true,
        ]);
    }
}
