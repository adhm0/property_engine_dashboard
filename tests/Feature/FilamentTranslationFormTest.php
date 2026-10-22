<?php

namespace Tests\Feature;

use App\Filament\Resources\Countries\Pages\CreateCountry;
use App\Filament\Resources\Countries\Pages\EditCountry;
use App\Models\Country;
use App\Models\Language;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentTranslationFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        foreach ([
            ['code' => 'ar', 'name' => 'Arabic', 'native_name' => 'العربية', 'direction' => 'RTL', 'is_default' => true],
            ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'direction' => 'LTR', 'is_default' => false],
        ] as $language) {
            Language::create([...$language, 'is_active' => true]);
        }
    }

    public function test_country_create_form_saves_arabic_and_english_translations(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateCountry::class)
            ->fillForm([
                'slug' => 'sa',
                'code' => 'SA',
                'key' => '+966',
                'name' => 'Saudi Arabia',
                'translations_data' => [
                    'ar' => ['name' => 'المملكة العربية السعودية'],
                    'en' => ['name' => 'Saudi Arabia'],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('translations', [
            'entity_type' => 'COUNTRY',
            'field' => 'name',
            'language_code' => 'ar',
            'value' => 'المملكة العربية السعودية',
        ]);

        $this->assertDatabaseHas('translations', [
            'entity_type' => 'COUNTRY',
            'field' => 'name',
            'language_code' => 'en',
            'value' => 'Saudi Arabia',
        ]);
    }

    public function test_country_edit_form_loads_existing_translations(): void
    {
        $this->actingAs(User::factory()->create());

        $country = Country::create([
            'slug' => 'sa',
            'code' => 'SA',
            'key' => '+966',
            'name' => 'Saudi Arabia',
            'translations_data' => [
                'ar' => ['name' => 'المملكة العربية السعودية'],
                'en' => ['name' => 'Saudi Arabia'],
            ],
        ]);

        Livewire::test(EditCountry::class, ['record' => $country->getRouteKey()])
            ->assertSchemaStateSet([
                'translations_data' => [
                    'ar' => ['name' => 'المملكة العربية السعودية'],
                    'en' => ['name' => 'Saudi Arabia'],
                ],
            ]);
    }
}
