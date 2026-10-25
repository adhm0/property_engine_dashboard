<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
{
    public function run(): void
    {
        PropertyType::updateOrCreate(
            ['code' => 'hotel'],
            ['is_active' => true],
        );

        PropertyType::updateOrCreate(
            ['code' => 'apartment'],
            ['is_active' => true],
        );

        PropertyType::updateOrCreate(
            ['code' => 'chalet'],
            ['is_active' => true],
        );

        PropertyType::updateOrCreate(
            ['code' => 'hall'],
            ['is_active' => true],
        );
    }
}
