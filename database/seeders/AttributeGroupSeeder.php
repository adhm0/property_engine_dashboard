<?php

namespace Database\Seeders;

use App\Models\AttributeGroup;
use Illuminate\Database\Seeder;

class AttributeGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['basic', 'home', 0, 'الأساسيات', 'Basic'],
            ['amenities', 'star', 1, 'المرافق', 'Amenities'],
            ['media', 'tv', 2, 'الترفيه والإعلام', 'Media & Entertainment'],
            ['bathroom', 'bath', 3, 'الحمام', 'Bathroom'],
            ['kitchen', 'fire', 4, 'المطبخ والطعام', 'Kitchen & Dining'],
            ['outdoor', 'sun', 5, 'المساحات الخارجية', 'Outdoor'],
            ['events', 'sparkles', 6, 'الفعاليات والمناسبات', 'Events & Weddings'],
            ['conference', 'presentation', 7, 'المؤتمرات والاجتماعات', 'Conferences & Meetings'],
            ['services', 'bell', 8, 'الخدمات', 'Services'],
            ['safety', 'shield', 9, 'السلامة والأمان', 'Safety & Security'],
            ['accessibility', 'accessible', 10, 'إمكانية الوصول', 'Accessibility'],
            ['parking', 'car', 11, 'المواقف والتنقل', 'Parking & Transport'],
            ['rules', 'gavel', 12, 'القواعد', 'Rules'],
            ['pricing', 'cash', 13, 'التسعير', 'Pricing'],
        ];

        foreach ($groups as [$code, $icon, $displayOrder, $nameAr, $nameEn]) {
            AttributeGroup::updateOrCreate(
                ['code' => $code],
                [
                    'icon' => $icon,
                    'display_order' => $displayOrder,
                    'is_active' => true,
                    'translations_data' => [
                        'ar' => ['code' => $nameAr],
                        'en' => ['code' => $nameEn],
                    ],
                ],
            );
        }
    }
}
