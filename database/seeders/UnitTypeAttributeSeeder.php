<?php

namespace Database\Seeders;

use App\Models\AttributeDefinition;
use App\Models\BookableUnitType;
use App\Models\UnitTypeAttribute;
use Illuminate\Database\Seeder;

class UnitTypeAttributeSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(BookableUnitTypeSeeder::class);
        $this->call(AttributeOptionSeeder::class);

        $roomBase = [
            'bedrooms', 'bathrooms', 'area_m2', 'max_guests', 'room_grade', 'bed_type',
            'has_wifi', 'has_air_conditioning', 'has_heating', 'has_smart_lock', 'has_workspace',
            'has_tv', 'has_smart_tv', 'has_netflix', 'has_bein_sports', 'has_sound_system',
            'has_private_bathroom', 'has_shower', 'shower_type', 'has_hairdryer', 'has_toiletries',
            'has_24h_reception', 'has_housekeeping', 'has_room_service', 'has_breakfast',
            'has_smoke_detector', 'has_fire_extinguisher', 'has_first_aid', 'has_safe',
            'is_wheelchair_accessible', 'has_accessible_bathroom', 'has_ramp', 'has_elevator',
            'has_parking', 'parking_spaces', 'parking_type', 'has_pool', 'view',
        ];

        $attributesByUnitType = [
            'single_room' => [...$roomBase, 'has_balcony'],
            'double_room' => [...$roomBase, 'has_balcony', 'has_terrace'],
            'suite' => [
                ...$roomBase,
                'has_bathtub', 'has_jacuzzi', 'has_lounge', 'has_dining_area', 'dining_seats',
                'kitchen_type', 'has_fridge', 'has_microwave', 'has_oven', 'has_coffee_machine',
                'has_balcony', 'has_terrace', 'pool_type', 'has_sauna', 'has_gym',
            ],
            'apartment_unit' => [
                ...$roomBase,
                'kitchen_type', 'has_fridge', 'has_microwave', 'has_oven', 'has_coffee_machine',
                'has_dishwasher', 'has_washer', 'has_dryer', 'has_dining_area', 'dining_seats',
                'has_balcony', 'has_terrace',
            ],
            'chalet_unit' => [
                ...$roomBase,
                'kitchen_type', 'has_fridge', 'has_microwave', 'has_oven', 'has_coffee_machine',
                'has_dishwasher', 'has_washer', 'has_dryer', 'has_dining_area', 'dining_seats',
                'has_balcony', 'has_terrace', 'has_garden', 'has_bbq_area', 'has_playground',
                'has_outdoor_seating', 'pool_type', 'has_jacuzzi',
            ],
            'panoramic_penthouse' => [
                ...$roomBase,
                'has_bathtub', 'has_jacuzzi', 'has_lounge', 'has_dining_area', 'dining_seats',
                'kitchen_type', 'has_fridge', 'has_microwave', 'has_oven', 'has_coffee_machine',
                'has_dishwasher', 'has_balcony', 'has_terrace', 'has_garden', 'has_outdoor_seating',
                'pool_type', 'has_sauna', 'has_gym',
            ],
            'majlis' => [
                'area_m2', 'max_guests', 'seat_count',
                'has_wifi', 'has_air_conditioning', 'has_heating', 'has_smart_lock', 'has_lounge',
                'has_tv', 'has_smart_tv', 'has_netflix', 'has_bein_sports', 'has_sound_system',
                'has_private_bathroom', 'has_toiletries',
                'kitchen_type', 'has_dining_area', 'dining_seats',
                'has_garden', 'has_outdoor_seating',
                'has_housekeeping', 'has_room_service', 'has_breakfast',
                'has_smoke_detector', 'has_fire_extinguisher', 'has_first_aid', 'has_safe',
                'is_wheelchair_accessible', 'has_accessible_bathroom', 'has_ramp', 'has_elevator',
                'has_parking', 'parking_spaces', 'parking_type', 'has_pool', 'pool_type', 'view',
            ],
            'hall_section' => [
                'area_m2', 'max_guests', 'event_capacity', 'chair_count', 'table_count',
                'has_wifi', 'has_air_conditioning', 'has_heating', 'has_sound_system', 'has_lighting_system',
                'has_kosha', 'has_stage', 'has_dance_floor', 'has_dining_hall', 'has_catering',
                'has_waitstaff', 'decoration_style', 'has_bridal_room', 'has_valet_parking',
                'has_private_bathroom', 'has_toiletries',
                'has_housekeeping', 'has_24h_reception',
                'has_smoke_detector', 'has_fire_extinguisher', 'has_first_aid', 'has_security_cameras', 'has_safe',
                'is_wheelchair_accessible', 'has_accessible_bathroom', 'has_ramp', 'has_elevator',
                'has_parking', 'parking_spaces', 'has_ev_charging', 'parking_type',
                'has_garden', 'has_outdoor_seating', 'has_pool', 'pool_type', 'view',
            ],
            'conference_hall' => [
                'area_m2', 'max_guests', 'event_capacity',
                'conference_table_count', 'conference_chair_count', 'screen_size_inches',
                'has_projector', 'projector_type', 'has_podium', 'has_microphone', 'microphone_count',
                'has_video_conferencing', 'has_whiteboard', 'has_flipchart', 'has_registration_desk', 'hall_layout',
                'has_wifi', 'has_air_conditioning', 'has_heating', 'has_sound_system', 'has_lighting_system',
                'has_private_bathroom', 'has_toiletries',
                'has_housekeeping', 'has_24h_reception', 'has_airport_shuttle',
                'has_smoke_detector', 'has_fire_extinguisher', 'has_first_aid', 'has_security_cameras', 'has_safe',
                'is_wheelchair_accessible', 'has_accessible_bathroom', 'has_ramp', 'has_elevator',
                'has_parking', 'parking_spaces', 'has_ev_charging', 'parking_type', 'view',
            ],
        ];

        $requiredByUnitType = [
            'single_room' => ['bedrooms', 'bathrooms'],
            'double_room' => ['bedrooms', 'bathrooms'],
            'suite' => ['bedrooms', 'bathrooms'],
            'apartment_unit' => ['bedrooms', 'bathrooms'],
            'chalet_unit' => ['bedrooms', 'bathrooms'],
            'panoramic_penthouse' => ['bedrooms', 'bathrooms'],
            'majlis' => ['area_m2', 'seat_count'],
            'hall_section' => ['area_m2', 'event_capacity', 'chair_count', 'table_count'],
            'conference_hall' => ['area_m2', 'event_capacity', 'conference_table_count', 'conference_chair_count'],
        ];

        $unitTypes = BookableUnitType::pluck('id', 'code');
        $attributes = AttributeDefinition::all()->keyBy('key');

        foreach ($attributesByUnitType as $unitTypeCode => $attributeKeys) {
            $unitTypeId = $unitTypes[$unitTypeCode] ?? null;

            if (! $unitTypeId) {
                continue;
            }

            $attributeIds = [];

            foreach (array_values($attributeKeys) as $sortOrder => $attributeKey) {
                $attribute = $attributes->get($attributeKey);

                if (! $attribute) {
                    continue;
                }

                $attributeIds[] = $attribute->id;

                UnitTypeAttribute::updateOrCreate(
                    [
                        'unit_type_id' => $unitTypeId,
                        'attribute_id' => $attribute->id,
                    ],
                    [
                        'is_required' => in_array($attributeKey, $requiredByUnitType[$unitTypeCode], true),
                        'is_filterable' => $attribute->is_filterable,
                        'is_displayable' => true,
                        'sort_order' => $sortOrder,
                    ],
                );
            }

            UnitTypeAttribute::where('unit_type_id', $unitTypeId)
                ->whereNotIn('attribute_id', $attributeIds)
                ->delete();
        }
    }
}
