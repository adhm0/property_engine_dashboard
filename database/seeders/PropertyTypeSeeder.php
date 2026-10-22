<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
{
    public function run(): void
    {
        PropertyType::create([
            'code' => 'hotel',
            'is_active' => true,
        ]);

        PropertyType::create([
            'code' => 'apartment',
            'is_active' => true,
        ]);

        PropertyType::create([
            'code' => 'chalet',
            'is_active' => true,
        ]);

        PropertyType::create([
            'code' => 'hall',
            'is_active' => true,
        ]);
    }
}
