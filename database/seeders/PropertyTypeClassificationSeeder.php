<?php

namespace Database\Seeders;

use App\Models\PropertyClassification;
use App\Models\PropertyType;
use App\Models\PropertyTypeClassification;
use Illuminate\Database\Seeder;

class PropertyTypeClassificationSeeder extends Seeder
{
    public function run(): void
    {
        $hotel = PropertyType::where('code', 'hotel')->firstOrFail();
        $apartment = PropertyType::where('code', 'apartment')->firstOrFail();
        $chalet = PropertyType::where('code', 'chalet')->firstOrFail();

        $standard = PropertyClassification::where('code', 'standard')->firstOrFail();
        $premium = PropertyClassification::where('code', 'premium')->firstOrFail();
        $luxury = PropertyClassification::where('code', 'luxury')->firstOrFail();

        PropertyTypeClassification::updateOrCreate(
            [
                'property_type_id' => $hotel->id,
                'classification_id' => $standard->id,
            ],
            ['is_active' => true],
        );

        PropertyTypeClassification::updateOrCreate(
            [
                'property_type_id' => $apartment->id,
                'classification_id' => $premium->id,
            ],
            ['is_active' => true],
        );

        PropertyTypeClassification::updateOrCreate(
            [
                'property_type_id' => $chalet->id,
                'classification_id' => $luxury->id,
            ],
            ['is_active' => true],
        );
    }
}
