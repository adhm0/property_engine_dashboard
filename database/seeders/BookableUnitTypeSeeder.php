<?php

namespace Database\Seeders;

use App\Models\BookableUnitType;
use Illuminate\Database\Seeder;

class BookableUnitTypeSeeder extends Seeder
{
    public function run(): void
    {
        $unitTypes = [
            'single_room',
            'double_room',
            'suite',
            'apartment_unit',
            'chalet_unit',
            'hall_section',
            'panoramic_penthouse',
            'majlis',
            'conference_hall',
        ];

        foreach ($unitTypes as $code) {
            BookableUnitType::updateOrCreate(
                ['code' => $code],
                ['is_active' => true],
            );
        }
    }
}
