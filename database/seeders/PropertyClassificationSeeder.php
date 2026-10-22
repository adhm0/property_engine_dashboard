<?php

namespace Database\Seeders;

use App\Models\PropertyClassification;
use Illuminate\Database\Seeder;

class PropertyClassificationSeeder extends Seeder
{
    public function run(): void
    {
        PropertyClassification::create([
            'code' => 'standard',
            'is_active' => true,
        ]);

        PropertyClassification::create([
            'code' => 'premium',
            'is_active' => true,
        ]);

        PropertyClassification::create([
            'code' => 'luxury',
            'is_active' => true,
        ]);

        PropertyClassification::create([
            'code' => 'family',
            'is_active' => true,
        ]);
    }
}
