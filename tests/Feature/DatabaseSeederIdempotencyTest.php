<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseSeederIdempotencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_can_run_twice_without_creating_duplicates(): void
    {
        $this->seed();

        $firstRun = $this->tableCounts();

        $this->seed();

        $this->assertSame($firstRun, $this->tableCounts());
        $this->assertGreaterThan(0, $firstRun['unit_type_attributes']);
        $this->assertGreaterThan(0, $firstRun['translations']);
    }

    /**
     * @return array<string, int>
     */
    private function tableCounts(): array
    {
        $tables = [
            'languages',
            'countries',
            'cities',
            'districts',
            'property_types',
            'property_classifications',
            'property_type_classifications',
            'bookable_unit_types',
            'attribute_groups',
            'attribute_definitions',
            'attribute_options',
            'unit_type_attributes',
            'translations',
            'users',
        ];

        return collect($tables)
            ->mapWithKeys(fn (string $table): array => [$table => DB::table($table)->count()])
            ->all();
    }
}
