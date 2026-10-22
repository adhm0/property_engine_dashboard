<?php

namespace Tests\Feature;

use App\Filament\Pages\Dashboard;
use App\Models\Country;
use App\Models\User;
use App\Support\SchemaExcelExporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PharData;
use Tests\TestCase;

class SchemaExcelExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_schema_exporter_creates_a_data_sheet_for_each_domain_table(): void
    {
        Country::create([
            'slug' => 'sa',
            'code' => 'SA',
            'key' => '+966',
            'name' => 'Saudi Arabia',
        ]);

        $path = app(SchemaExcelExporter::class)->export();

        try {
            $this->assertFileExists($path);

            $archive = new PharData($path);

            $this->assertTrue(isset($archive['[Content_Types].xml']));
            $this->assertTrue(isset($archive['xl/workbook.xml']));
            $this->assertTrue(isset($archive['xl/styles.xml']));
            $this->assertTrue(isset($archive['xl/worksheets/sheet1.xml']));

            $contents = file_get_contents($path);
            $this->assertSame(20, unpack('vversion', substr($contents, 4, 2))['version']);

            $endOfCentralDirectory = strrpos($contents, "PK\x05\x06");
            $this->assertNotFalse($endOfCentralDirectory);

            $directory = unpack(
                'vdisk/vcddisk/vdiskentries/ventries/Vcdsize/Vcdoffset/vcommentlen',
                substr($contents, $endOfCentralDirectory + 4, 18),
            );
            $centralHeader = substr($contents, $directory['cdoffset'], 46);

            $this->assertSame(20, unpack('vversionmade', substr($centralHeader, 4, 2))['versionmade']);
            $this->assertSame(20, unpack('vversionneeded', substr($centralHeader, 6, 2))['versionneeded']);

            $workbook = $archive['xl/workbook.xml']->getContent();

            $this->assertSame(17, substr_count($workbook, '<sheet '));
            $this->assertStringContainsString('name="Country"', $workbook);
            $this->assertStringContainsString('name="City"', $workbook);
            $this->assertStringContainsString('name="BookableUnitAttributeValue"', $workbook);
            $this->assertStringContainsString('name="Translation"', $workbook);
            $this->assertStringNotContainsString('name="Users"', $workbook);
            $this->assertStringNotContainsString('name="Migrations"', $workbook);

            $countrySheet = $archive['xl/worksheets/sheet1.xml']->getContent();

            $this->assertStringContainsString('>id<', $countrySheet);
            $this->assertStringContainsString('>slug<', $countrySheet);
            $this->assertStringContainsString('>code<', $countrySheet);
            $this->assertStringContainsString('>key<', $countrySheet);
            $this->assertStringContainsString('>name<', $countrySheet);
            $this->assertStringContainsString('Saudi Arabia', $countrySheet);
            $this->assertStringContainsString('sa', $countrySheet);
            $this->assertStringNotContainsString('createdAt', $countrySheet);
            $this->assertStringNotContainsString('updatedAt', $countrySheet);

            $citySheet = $archive['xl/worksheets/sheet2.xml']->getContent();
            $this->assertStringContainsString('>countryId<', $citySheet);
        } finally {
            @unlink($path);
        }
    }

    public function test_dashboard_has_schema_download_button(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertOk()
            ->assertSee('تحميل مخطط قاعدة البيانات');
    }

    public function test_dashboard_schema_download_action_returns_an_excel_file(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Dashboard::class)
            ->callAction('downloadDatabaseSchema')
            ->assertFileDownloaded();
    }
}
