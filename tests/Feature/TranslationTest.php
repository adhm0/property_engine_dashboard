<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranslationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Language::create([
            'code' => 'ar',
            'name' => 'Arabic',
            'native_name' => 'العربية',
            'direction' => 'RTL',
            'is_default' => true,
            'is_active' => true,
        ]);

        Language::create([
            'code' => 'en',
            'name' => 'English',
            'native_name' => 'English',
            'direction' => 'LTR',
            'is_default' => false,
            'is_active' => true,
        ]);
    }

    public function test_creating_an_entity_creates_translations_for_all_active_languages(): void
    {
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

        $translations = $country->translations()->pluck('value', 'language_code');

        $this->assertSame('المملكة العربية السعودية', $translations['ar']);
        $this->assertSame('Saudi Arabia', $translations['en']);
        $this->assertInstanceOf(Country::class, Translation::first()->entity);
    }

    public function test_updating_translations_updates_both_languages(): void
    {
        $country = Country::create([
            'slug' => 'sa',
            'code' => 'SA',
            'key' => '+966',
            'name' => 'Saudi Arabia',
        ]);

        $country->update([
            'translations_data' => [
                'ar' => ['name' => 'السعودية'],
                'en' => ['name' => 'KSA'],
            ],
        ]);

        $translations = $country->translations()->pluck('value', 'language_code');

        $this->assertSame('السعودية', $translations['ar']);
        $this->assertSame('KSA', $translations['en']);
    }

    public function test_deleting_an_entity_deletes_its_translations(): void
    {
        $country = Country::create([
            'slug' => 'sa',
            'code' => 'SA',
            'key' => '+966',
            'name' => 'Saudi Arabia',
        ]);

        $country->delete();

        $this->assertDatabaseCount('translations', 0);
    }
}
