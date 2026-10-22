<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $saudiArabia = Country::where('code', 'SA')->first();
        $uae = Country::where('code', 'AE')->first();
        $yemen = Country::where('code', 'YE')->first();

        City::create([
            'country_id' => $saudiArabia->id,
            'slug' => 'riyadh',
            'name' => 'Riyadh',
            'translations_data' => [
                'ar' => ['name' => 'الرياض'],
                'en' => ['name' => 'Riyadh'],
            ],
        ]);

        City::create([
            'country_id' => $saudiArabia->id,
            'slug' => 'jeddah',
            'name' => 'Jeddah',
            'translations_data' => [
                'ar' => ['name' => 'جدة'],
                'en' => ['name' => 'Jeddah'],
            ],
        ]);

        City::create([
            'country_id' => $uae->id,
            'slug' => 'dubai',
            'name' => 'Dubai',
            'translations_data' => [
                'ar' => ['name' => 'دبي'],
                'en' => ['name' => 'Dubai'],
            ],
        ]);

        City::create([
            'country_id' => $yemen->id,
            'slug' => 'sanaa',
            'name' => 'Sanaa',
            'translations_data' => [
                'ar' => ['name' => 'صنعاء'],
                'en' => ['name' => 'Sanaa'],
            ],
        ]);
    }
}
