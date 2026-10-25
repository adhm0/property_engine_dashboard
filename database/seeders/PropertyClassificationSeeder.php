<?php

namespace Database\Seeders;

use App\Models\PropertyClassification;
use Illuminate\Database\Seeder;

class PropertyClassificationSeeder extends Seeder
{
    public function run(): void
    {
        PropertyClassification::updateOrCreate(
            ['code' => 'standard'],
            ['is_active' => true],
        );

        PropertyClassification::updateOrCreate(
            ['code' => 'premium'],
            ['is_active' => true],
        );

        PropertyClassification::updateOrCreate(
            ['code' => 'luxury'],
            ['is_active' => true],
        );

        PropertyClassification::updateOrCreate(
            ['code' => 'family'],
            ['is_active' => true],
        );
    }
}
