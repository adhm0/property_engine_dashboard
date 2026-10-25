<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Country::updateOrCreate(
            ['code' => 'SA'],
            [
                'slug' => 'sa',
                'key' => '+966',
                'name' => 'Saudi Arabia',
                'translations_data' => [
                    'ar' => ['name' => 'المملكة العربية السعودية'],
                    'en' => ['name' => 'Saudi Arabia'],
                ],
            ],
        );

        Country::updateOrCreate(
            ['code' => 'AE'],
            [
                'slug' => 'ae',
                'key' => '+971',
                'name' => 'United Arab Emirates',
                'translations_data' => [
                    'ar' => ['name' => 'الإمارات العربية المتحدة'],
                    'en' => ['name' => 'United Arab Emirates'],
                ],
            ],
        );

        Country::updateOrCreate(
            ['code' => 'YE'],
            [
                'slug' => 'ye',
                'key' => '+967',
                'name' => 'Yemen',
                'translations_data' => [
                    'ar' => ['name' => 'اليمن'],
                    'en' => ['name' => 'Yemen'],
                ],
            ],
        );
    }
}
