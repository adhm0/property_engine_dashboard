<?php

namespace Database\Seeders;

use App\Models\BookableUnitType;
use Illuminate\Database\Seeder;

class BookableUnitTypeSeeder extends Seeder
{
    public function run(): void
    {
        BookableUnitType::create([
            'code' => 'single_room',
            'is_active' => true,
        ]);

        BookableUnitType::create([
            'code' => 'double_room',
            'is_active' => true,
        ]);

        BookableUnitType::create([
            'code' => 'suite',
            'is_active' => true,
        ]);

        BookableUnitType::create([
            'code' => 'apartment_unit',
            'is_active' => true,
        ]);

        BookableUnitType::create([
            'code' => 'chalet_unit',
            'is_active' => true,
        ]);

        BookableUnitType::create([
            'code' => 'hall_section',
            'is_active' => true,
        ]);
    }
}
