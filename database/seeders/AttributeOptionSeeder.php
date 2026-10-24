<?php

namespace Database\Seeders;

use App\Models\AttributeDefinition;
use App\Models\AttributeOption;
use Illuminate\Database\Seeder;

class AttributeOptionSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AttributeDefinitionSeeder::class);

        $options = [
            'room_grade' => [
                ['standard', 'عادي', 'Standard'],
                ['deluxe', 'ديلوكس', 'Deluxe'],
                ['executive', 'تنفيذي', 'Executive'],
                ['presidential', 'رئاسي', 'Presidential'],
                ['royal', 'ملكي', 'Royal'],
            ],
            'bed_type' => [
                ['single', 'فردي', 'Single'],
                ['double', 'مزدوج', 'Double'],
                ['queen', 'كوين', 'Queen'],
                ['king', 'كينغ', 'King'],
                ['twin', 'توأم', 'Twin'],
                ['bunk', 'دورين', 'Bunk'],
            ],
            'view' => [
                ['sea_view', 'إطلالة على البحر', 'Sea View'],
                ['city_view', 'إطلالة على المدينة', 'City View'],
                ['garden_view', 'إطلالة على الحديقة', 'Garden View'],
                ['mountain_view', 'إطلالة على الجبال', 'Mountain View'],
                ['pool_view', 'إطلالة على المسبح', 'Pool View'],
                ['street_view', 'إطلالة على الشارع', 'Street View'],
                ['courtyard_view', 'إطلالة على الفناء', 'Courtyard View'],
            ],
            'shower_type' => [
                ['rain', 'دش مطري', 'Rain Shower'],
                ['handheld', 'دش يدوي', 'Handheld Shower'],
                ['both', 'كلاهما', 'Both'],
                ['none', 'بدون دش', 'None'],
            ],
            'kitchen_type' => [
                ['none', 'بدون مطبخ', 'None'],
                ['kitchenette', 'مطبخ صغير', 'Kitchenette'],
                ['full_kitchen', 'مطبخ كامل', 'Full Kitchen'],
                ['open_kitchen', 'مطبخ مفتوح', 'Open Kitchen'],
            ],
            'pool_type' => [
                ['none', 'بدون مسبح', 'None'],
                ['private', 'مسبح خاص', 'Private Pool'],
                ['shared', 'مسبح مشترك', 'Shared Pool'],
                ['heated', 'مسبح مدفأ', 'Heated Pool'],
                ['infinity', 'مسبح إنفينيتي', 'Infinity Pool'],
            ],
            'decoration_style' => [
                ['classic', 'كلاسيكي', 'Classic'],
                ['modern', 'عصري', 'Modern'],
                ['luxury', 'فاخر', 'Luxury'],
                ['floral', 'زهري', 'Floral'],
                ['rustic', 'ريفي', 'Rustic'],
                ['custom', 'مخصص', 'Custom'],
            ],
            'projector_type' => [
                ['none', 'بدون بروجكتور', 'None'],
                ['hd', 'HD', 'HD'],
                ['full_hd', 'Full HD', 'Full HD'],
                ['4k', '4K', '4K'],
                ['laser', 'ليزر', 'Laser'],
            ],
            'hall_layout' => [
                ['theater', 'مسرحي', 'Theater'],
                ['classroom', 'فصول دراسية', 'Classroom'],
                ['u_shape', 'على شكل U', 'U-Shape'],
                ['banquet', 'مأدبة', 'Banquet'],
                ['boardroom', 'غرفة اجتماعات', 'Boardroom'],
                ['cocktail', 'كوكتيل', 'Cocktail'],
                ['exhibition', 'معرض', 'Exhibition'],
            ],
            'parking_type' => [
                ['free', 'موقف مجاني', 'Free'],
                ['paid', 'موقف مدفوع', 'Paid'],
                ['valet', 'صف سيارات', 'Valet'],
                ['underground', 'موقف تحت الأرض', 'Underground'],
                ['street', 'موقف شارع', 'Street'],
            ],
        ];

        $attributeIds = AttributeDefinition::pluck('id', 'key');

        foreach ($options as $attributeKey => $attributeOptions) {
            $attributeId = $attributeIds[$attributeKey] ?? null;

            if (! $attributeId) {
                continue;
            }

            foreach ($attributeOptions as $sortOrder => [$value, $labelAr, $labelEn]) {
                AttributeOption::updateOrCreate(
                    [
                        'attribute_id' => $attributeId,
                        'value' => $value,
                    ],
                    [
                        'icon' => null,
                        'sort_order' => $sortOrder,
                        'is_active' => true,
                        'translations_data' => [
                            'ar' => ['value' => $labelAr],
                            'en' => ['value' => $labelEn],
                        ],
                    ],
                );
            }
        }
    }
}
