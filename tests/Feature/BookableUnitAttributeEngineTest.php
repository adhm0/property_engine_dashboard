<?php

namespace Tests\Feature;

use App\Filament\Resources\BookableUnits\Pages\CreateBookableUnit;
use App\Filament\Resources\BookableUnits\Pages\EditBookableUnit;
use App\Models\AttributeDefinition;
use App\Models\AttributeGroup;
use App\Models\AttributeOption;
use App\Models\BookableUnit;
use App\Models\BookableUnitAttributeValue;
use App\Models\BookableUnitType;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Property;
use App\Models\PropertyClassification;
use App\Models\PropertyType;
use App\Models\PropertyTypeClassification;
use App\Models\UnitTypeAttribute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Tests\TestCase;

class BookableUnitAttributeEngineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_syncing_attribute_values_stores_typed_columns_and_builds_filter_payload(): void
    {
        $unit = $this->makeUnit();

        [$area, $wifi, $view, $description, $viewOption] = $this->makeAttributes($unit->unit_type_id);

        $unit->syncAttributeValues([
            $area->id => ['value_number' => 120.5],
            $wifi->id => ['value_boolean' => false],
            $view->id => ['option_id' => $viewOption->id],
            $description->id => ['value_string' => 'إطلالة كاملة على البحر'],
        ]);

        $this->assertDatabaseHas('bookable_unit_attribute_values', [
            'unit_id' => $unit->id,
            'attribute_id' => $area->id,
            'value_number' => 120.5,
        ]);

        $this->assertDatabaseHas('bookable_unit_attribute_values', [
            'unit_id' => $unit->id,
            'attribute_id' => $wifi->id,
            'value_boolean' => false,
        ]);

        $this->assertDatabaseHas('bookable_unit_attribute_values', [
            'unit_id' => $unit->id,
            'attribute_id' => $view->id,
            'option_id' => $viewOption->id,
        ]);

        $this->assertEquals([
            'area' => 120.5,
            'wifi' => false,
            'view' => 'sea',
            'description' => 'إطلالة كاملة على البحر',
        ], $unit->fresh()->filter_attributes);
    }

    public function test_updating_attribute_values_replaces_old_values_and_filter_payload(): void
    {
        $unit = $this->makeUnit();

        [$area, $wifi, $view, $description, $viewOption] = $this->makeAttributes($unit->unit_type_id);

        $unit->syncAttributeValues([
            $area->id => ['value_number' => 80],
            $wifi->id => ['value_boolean' => true],
            $view->id => ['option_id' => $viewOption->id],
            $description->id => ['value_string' => 'قديم'],
        ]);

        $unit->syncAttributeValues([
            $area->id => ['value_number' => 95],
            $wifi->id => [],
            $view->id => [],
            $description->id => ['value_string' => 'جديد'],
        ]);

        $filters = $unit->fresh()->filter_attributes;

        $this->assertEquals(95.0, $filters['area']);
        $this->assertSame('جديد', $filters['description']);
        $this->assertArrayNotHasKey('wifi', $filters);
        $this->assertArrayNotHasKey('view', $filters);

        $this->assertDatabaseMissing('bookable_unit_attribute_values', [
            'unit_id' => $unit->id,
            'attribute_id' => $wifi->id,
        ]);
    }

    public function test_attribute_value_rejects_attribute_not_assigned_to_unit_type(): void
    {
        $unit = $this->makeUnit();

        $group = AttributeGroup::create(['code' => 'qa']);

        $unassigned = AttributeDefinition::create([
            'key' => 'unassigned',
            'value_type' => 'TEXT',
            'group_id' => $group->id,
        ]);

        $this->expectException(ValidationException::class);

        BookableUnitAttributeValue::create([
            'unit_id' => $unit->id,
            'attribute_id' => $unassigned->id,
            'value_string' => 'value',
        ]);
    }

    public function test_bookable_unit_filament_form_saves_dynamic_attribute_values(): void
    {
        $unit = $this->makeUnit(createUnit: false);
        $property = $unit->property;

        [$area, $wifi, $view, $description, $viewOption] = $this->makeAttributes($unit->unit_type_id);

        Livewire::test(CreateBookableUnit::class)
            ->fillForm([
                'property_id' => $property->id,
                'unit_type_id' => $unit->unit_type_id,
                'name' => 'Unit with attributes',
                'capacity' => 3,
                'base_price' => 500,
                'status' => 'ACTIVE',
                'attribute_values_data' => [
                    $area->id => ['value_number' => 45],
                    $wifi->id => ['value_boolean' => true],
                    $view->id => ['option_id' => $viewOption->id],
                    $description->id => ['value_string' => 'وصف تجريبي'],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $created = BookableUnit::query()->where('name', 'Unit with attributes')->firstOrFail();

        $this->assertDatabaseHas('bookable_unit_attribute_values', [
            'unit_id' => $created->id,
            'attribute_id' => $area->id,
            'value_number' => 45,
        ]);

        $this->assertEquals([
            'area' => 45.0,
            'wifi' => true,
            'view' => 'sea',
            'description' => 'وصف تجريبي',
        ], $created->filter_attributes);
    }

    public function test_edit_form_updates_existing_dynamic_attribute_values(): void
    {
        $unit = $this->makeUnit();

        [$area] = $this->makeAttributes($unit->unit_type_id);

        $unit->syncAttributeValues([
            $area->id => ['value_number' => 70],
        ]);

        Livewire::test(EditBookableUnit::class, ['record' => $unit->getRouteKey()])
            ->fillForm([
                "attribute_values_data.{$area->id}.value_number" => 88,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertEquals(88.0, $unit->fresh()->filter_attributes['area']);
    }

    public function test_attribute_management_pages_render(): void
    {
        $this->get('/admin/unit-type-attributes/create')->assertSuccessful();
        $this->get('/admin/bookable-unit-attribute-values')->assertSuccessful();
        $this->get('/admin/bookable-unit-attribute-values/create')->assertSuccessful();
    }

    public function test_bookable_unit_view_page_renders_filter_attributes(): void
    {
        $unit = $this->makeUnit();

        [$area] = $this->makeAttributes($unit->unit_type_id);

        $unit->syncAttributeValues([
            $area->id => ['value_number' => 70],
        ]);

        $this->get("/admin/bookable-units/{$unit->id}")->assertSuccessful();
    }

    protected function makeUnit(bool $createUnit = true): BookableUnit
    {
        $property = $this->makeProperty();

        $unitType = BookableUnitType::create(['code' => 'VILLA_ROOM']);

        $unit = new BookableUnit([
            'property_id' => $property->id,
            'unit_type_id' => $unitType->id,
            'name' => 'Test Unit',
            'capacity' => 2,
            'base_price' => 300,
            'status' => 'ACTIVE',
        ]);

        if ($createUnit) {
            $unit->save();
        } else {
            $unit->id = (string) Str::uuid();
        }

        return $unit;
    }

    protected function makeAttributes(string $unitTypeId): array
    {
        $group = AttributeGroup::create(['code' => 'specs']);

        $area = AttributeDefinition::create([
            'key' => 'area',
            'value_type' => 'NUMBER',
            'group_id' => $group->id,
            'is_filterable' => true,
        ]);

        $wifi = AttributeDefinition::create([
            'key' => 'wifi',
            'value_type' => 'BOOLEAN',
            'group_id' => $group->id,
            'is_filterable' => true,
        ]);

        $view = AttributeDefinition::create([
            'key' => 'view',
            'value_type' => 'ENUM',
            'group_id' => $group->id,
            'is_filterable' => true,
        ]);

        $description = AttributeDefinition::create([
            'key' => 'description',
            'value_type' => 'TEXT',
            'group_id' => $group->id,
            'is_filterable' => true,
        ]);

        $viewOption = AttributeOption::create([
            'attribute_id' => $view->id,
            'value' => 'sea',
        ]);

        foreach ([$area, $wifi, $view, $description] as $definition) {
            UnitTypeAttribute::create([
                'unit_type_id' => $unitTypeId,
                'attribute_id' => $definition->id,
                'is_filterable' => true,
            ]);
        }

        return [$area, $wifi, $view, $description, $viewOption];
    }

    protected function makeProperty(): Property
    {
        $owner = User::factory()->create();

        $country = Country::create([
            'slug' => 'sa',
            'code' => 'SA',
            'key' => '+966',
            'name' => 'Saudi Arabia',
        ]);

        $city = City::create([
            'country_id' => $country->id,
            'slug' => 'riyadh',
            'name' => 'Riyadh',
        ]);

        $district = District::create([
            'city_id' => $city->id,
            'slug' => 'olaya',
            'name' => 'Olaya',
        ]);

        $type = PropertyType::create(['code' => 'VILLA']);
        $classification = PropertyClassification::create(['code' => 'LUXURY']);

        $typeClassification = PropertyTypeClassification::create([
            'property_type_id' => $type->id,
            'classification_id' => $classification->id,
        ]);

        return Property::create([
            'owner_id' => $owner->id,
            'property_type_classification_id' => $typeClassification->id,
            'district_id' => $district->id,
            'name' => 'Test Property',
            'status' => 'ACTIVE',
        ]);
    }
}
