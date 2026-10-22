<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Country::create([
            'slug' => 'sa',
            'code' => 'SA',
            'key' => '+966',
            'name' => 'Saudi Arabia',
            'translations_data' => [
                'ar' => ['name' => 'المملكة العربية السعودية'],
                'en' => ['name' => 'Saudi Arabia'],
            ],
        ]);

        Country::create([
            'slug' => 'ae',
            'code' => 'AE',
            'key' => '+971',
            'name' => 'United Arab Emirates',
            'translations_data' => [
                'ar' => ['name' => 'الإمارات العربية المتحدة'],
                'en' => ['name' => 'United Arab Emirates'],
            ],
        ]);

        Country::create([
            'slug' => 'ye',
            'code' => 'YE',
            'key' => '+967',
            'name' => 'Yemen',
            'translations_data' => [
                'ar' => ['name' => 'اليمن'],
                'en' => ['name' => 'Yemen'],
            ],
        ]);
    }
}
