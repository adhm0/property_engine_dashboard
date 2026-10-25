<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $riyadh = City::where('slug', 'riyadh')->firstOrFail();
        $dubai = City::where('slug', 'dubai')->firstOrFail();
        $sanaa = City::where('slug', 'sanaa')->firstOrFail();

        District::updateOrCreate(
            ['city_id' => $riyadh->id, 'slug' => 'al-olaya'],
            [
                'name' => 'Al Olaya',
                'translations_data' => [
                    'ar' => ['name' => 'العليا'],
                    'en' => ['name' => 'Al Olaya'],
                ],
            ],
        );

        District::updateOrCreate(
            ['city_id' => $riyadh->id, 'slug' => 'al-malqa'],
            [
                'name' => 'Al Malqa',
                'translations_data' => [
                    'ar' => ['name' => 'الملقا'],
                    'en' => ['name' => 'Al Malqa'],
                ],
            ],
        );

        District::updateOrCreate(
            ['city_id' => $dubai->id, 'slug' => 'downtown-dubai'],
            [
                'name' => 'Downtown Dubai',
                'translations_data' => [
                    'ar' => ['name' => 'وسط مدينة دبي'],
                    'en' => ['name' => 'Downtown Dubai'],
                ],
            ],
        );

        District::updateOrCreate(
            ['city_id' => $sanaa->id, 'slug' => 'hadda'],
            [
                'name' => 'Hadda',
                'translations_data' => [
                    'ar' => ['name' => 'حدة'],
                    'en' => ['name' => 'Hadda'],
                ],
            ],
        );
    }
}
