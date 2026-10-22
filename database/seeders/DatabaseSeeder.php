<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
            PropertyTypeSeeder::class,
            PropertyClassificationSeeder::class,
            PropertyTypeClassificationSeeder::class,
            BookableUnitTypeSeeder::class,
            AttributeGroupSeeder::class,
            AttributeDefinitionSeeder::class,
            AttributeOptionSeeder::class,
            UnitTypeAttributeSeeder::class,
            TranslationBackfillSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
