<?php

namespace Database\Seeders;

use App\Models\AttributeDefinition;
use App\Models\AttributeGroup;
use Illuminate\Database\Seeder;

class AttributeDefinitionSeeder extends Seeder
{
    protected array $groupIds = [];

    public function run(): void
    {
        $this->call(AttributeGroupSeeder::class);

        $this->groupIds = AttributeGroup::pluck('id', 'code')->all();

        $this->define('bedrooms', 'basic', 'NUMBER', 'عدد غرف النوم', 'Bedrooms', ['icon' => 'bed', 'unit' => 'room', 'filterable' => true, 'order' => 0]);
        $this->define('bathrooms', 'basic', 'NUMBER', 'عدد الحمامات', 'Bathrooms', ['icon' => 'bath', 'unit' => 'room', 'filterable' => true, 'order' => 1]);
        $this->define('area_m2', 'basic', 'NUMBER', 'المساحة (م²)', 'Area (m²)', ['icon' => 'expand', 'unit' => 'm2', 'filterable' => false, 'order' => 2]);
        $this->define('max_guests', 'basic', 'NUMBER', 'الحد الأقصى للضيوف', 'Max Guests', ['icon' => 'users', 'unit' => 'person', 'filterable' => true, 'order' => 3]);
        $this->define('room_grade', 'basic', 'ENUM', 'تصنيف الغرفة', 'Room Grade', ['icon' => 'star', 'filterable' => true, 'order' => 4]);
        $this->define('bed_type', 'basic', 'ENUM', 'نوع السرير', 'Bed Type', ['icon' => 'bed', 'filterable' => true, 'order' => 5]);
        $this->define('seat_count', 'basic', 'NUMBER', 'عدد المقاعد', 'Seats', ['icon' => 'users', 'unit' => 'seat', 'filterable' => true, 'order' => 6]);

        $this->define('has_wifi', 'amenities', 'BOOLEAN', 'واي فاي', 'Wi-Fi', ['icon' => 'wifi', 'filterable' => true, 'order' => 0]);
        $this->define('has_air_conditioning', 'amenities', 'BOOLEAN', 'تكييف', 'Air Conditioning', ['icon' => 'snowflake', 'filterable' => true, 'order' => 1]);
        $this->define('has_heating', 'amenities', 'BOOLEAN', 'تدفئة', 'Heating', ['icon' => 'fire', 'filterable' => true, 'order' => 2]);
        $this->define('has_smart_lock', 'amenities', 'BOOLEAN', 'قفل ذكي', 'Smart Lock', ['icon' => 'key', 'filterable' => false, 'order' => 3]);
        $this->define('has_workspace', 'amenities', 'BOOLEAN', 'مكتب عمل', 'Workspace', ['icon' => 'briefcase', 'filterable' => true, 'order' => 4]);
        $this->define('has_sauna', 'amenities', 'BOOLEAN', 'ساونا', 'Sauna', ['icon' => 'fire', 'filterable' => true, 'order' => 5]);
        $this->define('has_gym', 'amenities', 'BOOLEAN', 'صالة رياضية', 'Gym', ['icon' => 'heart', 'filterable' => true, 'order' => 6]);
        $this->define('has_pool', 'amenities', 'BOOLEAN', 'مسبح', 'Pool', ['icon' => 'pool', 'filterable' => true, 'order' => 7]);
        $this->define('has_lounge', 'amenities', 'BOOLEAN', 'صالة جلوس', 'Lounge', ['icon' => 'sofa', 'filterable' => true, 'order' => 8]);

        $this->define('has_tv', 'media', 'BOOLEAN', 'تلفاز', 'TV', ['icon' => 'tv', 'filterable' => true, 'order' => 0]);
        $this->define('has_smart_tv', 'media', 'BOOLEAN', 'تلفاز ذكي', 'Smart TV', ['icon' => 'tv', 'filterable' => true, 'order' => 1]);
        $this->define('has_netflix', 'media', 'BOOLEAN', 'نتفليكس', 'Netflix', ['icon' => 'play', 'filterable' => true, 'order' => 2]);
        $this->define('has_bein_sports', 'media', 'BOOLEAN', 'بي إن سبورت', 'beIN Sports', ['icon' => 'play', 'filterable' => true, 'order' => 3]);
        $this->define('has_sound_system', 'media', 'BOOLEAN', 'نظام صوت', 'Sound System', ['icon' => 'speaker', 'filterable' => true, 'order' => 4]);
        $this->define('has_gaming_console', 'media', 'BOOLEAN', 'جهاز ألعاب', 'Gaming Console', ['icon' => 'gamepad', 'filterable' => true, 'order' => 5]);

        $this->define('has_private_bathroom', 'bathroom', 'BOOLEAN', 'حمام خاص', 'Private Bathroom', ['icon' => 'bath', 'filterable' => true, 'order' => 0]);
        $this->define('has_bathtub', 'bathroom', 'BOOLEAN', 'حوض استحمام', 'Bathtub', ['icon' => 'bath', 'filterable' => true, 'order' => 1]);
        $this->define('has_shower', 'bathroom', 'BOOLEAN', 'دش', 'Shower', ['icon' => 'shower', 'filterable' => true, 'order' => 2]);
        $this->define('shower_type', 'bathroom', 'ENUM', 'نوع الدش', 'Shower Type', ['icon' => 'shower', 'filterable' => true, 'order' => 3]);
        $this->define('has_jacuzzi', 'bathroom', 'BOOLEAN', 'جاكوزي', 'Jacuzzi', ['icon' => 'bath', 'filterable' => true, 'order' => 4]);
        $this->define('has_hairdryer', 'bathroom', 'BOOLEAN', 'مجفف شعر', 'Hair Dryer', ['icon' => 'wind', 'filterable' => false, 'order' => 5]);
        $this->define('has_toiletries', 'bathroom', 'BOOLEAN', 'مستلزمات الحمام', 'Toiletries', ['icon' => 'sparkles', 'filterable' => false, 'order' => 6]);

        $this->define('kitchen_type', 'kitchen', 'ENUM', 'نوع المطبخ', 'Kitchen Type', ['icon' => 'fire', 'filterable' => true, 'order' => 0]);
        $this->define('has_fridge', 'kitchen', 'BOOLEAN', 'ثلاجة', 'Fridge', ['icon' => 'cube', 'filterable' => true, 'order' => 1]);
        $this->define('has_microwave', 'kitchen', 'BOOLEAN', 'ميكروويف', 'Microwave', ['icon' => 'fire', 'filterable' => true, 'order' => 2]);
        $this->define('has_oven', 'kitchen', 'BOOLEAN', 'فرن', 'Oven', ['icon' => 'fire', 'filterable' => true, 'order' => 3]);
        $this->define('has_coffee_machine', 'kitchen', 'BOOLEAN', 'آلة قهوة', 'Coffee Machine', ['icon' => 'coffee', 'filterable' => true, 'order' => 4]);
        $this->define('has_dishwasher', 'kitchen', 'BOOLEAN', 'غسالة أطباق', 'Dishwasher', ['icon' => 'sparkles', 'filterable' => false, 'order' => 5]);
        $this->define('has_washer', 'kitchen', 'BOOLEAN', 'غسالة ملابس', 'Washing Machine', ['icon' => 'refresh', 'filterable' => false, 'order' => 6]);
        $this->define('has_dryer', 'kitchen', 'BOOLEAN', 'مجفف ملابس', 'Dryer', ['icon' => 'wind', 'filterable' => false, 'order' => 7]);
        $this->define('has_dining_area', 'kitchen', 'BOOLEAN', 'منطقة طعام', 'Dining Area', ['icon' => 'table', 'filterable' => true, 'order' => 8]);
        $this->define('dining_seats', 'kitchen', 'NUMBER', 'عدد مقاعد الطعام', 'Dining Seats', ['icon' => 'table', 'unit' => 'seat', 'filterable' => true, 'order' => 9]);

        $this->define('has_balcony', 'outdoor', 'BOOLEAN', 'شرفة', 'Balcony', ['icon' => 'building', 'filterable' => true, 'order' => 0]);
        $this->define('has_terrace', 'outdoor', 'BOOLEAN', 'تراس', 'Terrace', ['icon' => 'sun', 'filterable' => true, 'order' => 1]);
        $this->define('has_garden', 'outdoor', 'BOOLEAN', 'حديقة', 'Garden', ['icon' => 'tree', 'filterable' => true, 'order' => 2]);
        $this->define('has_bbq_area', 'outdoor', 'BOOLEAN', 'منطقة شواء', 'BBQ Area', ['icon' => 'fire', 'filterable' => true, 'order' => 3]);
        $this->define('has_playground', 'outdoor', 'BOOLEAN', 'ألعاب أطفال', 'Playground', ['icon' => 'puzzle', 'filterable' => true, 'order' => 4]);
        $this->define('has_outdoor_seating', 'outdoor', 'BOOLEAN', 'جلسات خارجية', 'Outdoor Seating', ['icon' => 'chair', 'filterable' => true, 'order' => 5]);
        $this->define('pool_type', 'outdoor', 'ENUM', 'نوع المسبح', 'Pool Type', ['icon' => 'pool', 'filterable' => true, 'order' => 6]);
        $this->define('view', 'outdoor', 'ENUM', 'الإطلالة', 'View', ['icon' => 'visibility', 'filterable' => true, 'order' => 7]);

        $this->define('event_capacity', 'events', 'NUMBER', 'سعة الفعالية', 'Event Capacity', ['icon' => 'users', 'unit' => 'person', 'filterable' => true, 'order' => 0]);
        $this->define('chair_count', 'events', 'NUMBER', 'عدد الكراسي', 'Chairs', ['icon' => 'chair', 'unit' => 'chair', 'filterable' => true, 'order' => 1]);
        $this->define('table_count', 'events', 'NUMBER', 'عدد الطاولات', 'Tables', ['icon' => 'table', 'unit' => 'table', 'filterable' => true, 'order' => 2]);
        $this->define('has_kosha', 'events', 'BOOLEAN', 'كوشة العروس', 'Bridal Kosha', ['icon' => 'star', 'filterable' => true, 'order' => 3]);
        $this->define('has_stage', 'events', 'BOOLEAN', 'منصة', 'Stage', ['icon' => 'presentation', 'filterable' => true, 'order' => 4]);
        $this->define('has_dance_floor', 'events', 'BOOLEAN', 'أرضية رقص', 'Dance Floor', ['icon' => 'music', 'filterable' => true, 'order' => 5]);
        $this->define('has_dining_hall', 'events', 'BOOLEAN', 'صالة طعام', 'Dining Hall', ['icon' => 'table', 'filterable' => true, 'order' => 6]);
        $this->define('has_catering', 'events', 'BOOLEAN', 'خدمات ضيافة', 'Catering', ['icon' => 'cake', 'filterable' => true, 'order' => 7]);
        $this->define('has_waitstaff', 'events', 'BOOLEAN', 'طاقم خدمة', 'Waitstaff', ['icon' => 'users', 'filterable' => true, 'order' => 8]);
        $this->define('has_lighting_system', 'events', 'BOOLEAN', 'نظام إضاءة', 'Lighting System', ['icon' => 'lightbulb', 'filterable' => true, 'order' => 9]);
        $this->define('decoration_style', 'events', 'ENUM', 'نمط الديكور', 'Decoration Style', ['icon' => 'sparkles', 'filterable' => true, 'order' => 10]);
        $this->define('has_bridal_room', 'events', 'BOOLEAN', 'غرفة عروس', 'Bridal Room', ['icon' => 'heart', 'filterable' => true, 'order' => 11]);
        $this->define('has_valet_parking', 'events', 'BOOLEAN', 'خدمة صف السيارات', 'Valet Parking', ['icon' => 'car', 'filterable' => true, 'order' => 12]);

        $this->define('conference_table_count', 'conference', 'NUMBER', 'عدد طاولات المؤتمر', 'Conference Tables', ['icon' => 'table', 'unit' => 'table', 'filterable' => true, 'order' => 0]);
        $this->define('conference_chair_count', 'conference', 'NUMBER', 'عدد كراسي المؤتمر', 'Conference Chairs', ['icon' => 'chair', 'unit' => 'chair', 'filterable' => true, 'order' => 1]);
        $this->define('screen_size_inches', 'conference', 'NUMBER', 'حجم الشاشة (إنش)', 'Screen Size (inch)', ['icon' => 'tv', 'unit' => 'inch', 'filterable' => true, 'order' => 2]);
        $this->define('has_projector', 'conference', 'BOOLEAN', 'بروجكتور', 'Projector', ['icon' => 'video-camera', 'filterable' => true, 'order' => 3]);
        $this->define('projector_type', 'conference', 'ENUM', 'نوع البروجكتور', 'Projector Type', ['icon' => 'video-camera', 'filterable' => true, 'order' => 4]);
        $this->define('has_podium', 'conference', 'BOOLEAN', 'منصة خطاب', 'Podium', ['icon' => 'presentation', 'filterable' => true, 'order' => 5]);
        $this->define('has_microphone', 'conference', 'BOOLEAN', 'ميكروفون', 'Microphone', ['icon' => 'microphone', 'filterable' => true, 'order' => 6]);
        $this->define('microphone_count', 'conference', 'NUMBER', 'عدد الميكروفونات', 'Microphones', ['icon' => 'microphone', 'unit' => 'unit', 'filterable' => true, 'order' => 7]);
        $this->define('has_video_conferencing', 'conference', 'BOOLEAN', 'مؤتمرات مرئية', 'Video Conferencing', ['icon' => 'video-camera', 'filterable' => true, 'order' => 8]);
        $this->define('has_whiteboard', 'conference', 'BOOLEAN', 'سبورة بيضاء', 'Whiteboard', ['icon' => 'presentation', 'filterable' => true, 'order' => 9]);
        $this->define('has_flipchart', 'conference', 'BOOLEAN', 'لوح ورقي', 'Flipchart', ['icon' => 'presentation', 'filterable' => false, 'order' => 10]);
        $this->define('has_registration_desk', 'conference', 'BOOLEAN', 'مكتب تسجيل', 'Registration Desk', ['icon' => 'clipboard', 'filterable' => true, 'order' => 11]);
        $this->define('hall_layout', 'conference', 'ENUM', 'ترتيب القاعة', 'Hall Layout', ['icon' => 'table', 'filterable' => true, 'order' => 12]);

        $this->define('has_24h_reception', 'services', 'BOOLEAN', 'استقبال 24 ساعة', '24h Reception', ['icon' => 'clock', 'filterable' => true, 'order' => 0]);
        $this->define('has_housekeeping', 'services', 'BOOLEAN', 'خدمة تنظيف', 'Housekeeping', ['icon' => 'sparkles', 'filterable' => true, 'order' => 1]);
        $this->define('has_airport_shuttle', 'services', 'BOOLEAN', 'نقل من المطار', 'Airport Shuttle', ['icon' => 'truck', 'filterable' => true, 'order' => 2]);
        $this->define('has_laundry_service', 'services', 'BOOLEAN', 'خدمة غسيل', 'Laundry Service', ['icon' => 'refresh', 'filterable' => true, 'order' => 3]);
        $this->define('has_breakfast', 'services', 'BOOLEAN', 'إفطار', 'Breakfast', ['icon' => 'cake', 'filterable' => true, 'order' => 4]);
        $this->define('has_room_service', 'services', 'BOOLEAN', 'خدمة الغرف', 'Room Service', ['icon' => 'bell', 'filterable' => true, 'order' => 5]);

        $this->define('has_smoke_detector', 'safety', 'BOOLEAN', 'كاشف دخان', 'Smoke Detector', ['icon' => 'fire', 'filterable' => true, 'order' => 0]);
        $this->define('has_fire_extinguisher', 'safety', 'BOOLEAN', 'طفاية حريق', 'Fire Extinguisher', ['icon' => 'fire', 'filterable' => true, 'order' => 1]);
        $this->define('has_first_aid', 'safety', 'BOOLEAN', 'إسعافات أولية', 'First Aid', ['icon' => 'plus', 'filterable' => true, 'order' => 2]);
        $this->define('has_security_cameras', 'safety', 'BOOLEAN', 'كاميرات مراقبة', 'Security Cameras', ['icon' => 'video-camera', 'filterable' => true, 'order' => 3]);
        $this->define('has_safe', 'safety', 'BOOLEAN', 'خزنة', 'Safe', ['icon' => 'lock', 'filterable' => true, 'order' => 4]);

        $this->define('is_wheelchair_accessible', 'accessibility', 'BOOLEAN', 'مناسب للكراسي المتحركة', 'Wheelchair Accessible', ['icon' => 'accessible', 'filterable' => true, 'order' => 0]);
        $this->define('has_accessible_bathroom', 'accessibility', 'BOOLEAN', 'حمام مهيأ', 'Accessible Bathroom', ['icon' => 'accessible', 'filterable' => true, 'order' => 1]);
        $this->define('has_ramp', 'accessibility', 'BOOLEAN', 'منحدر', 'Ramp', ['icon' => 'arrow-up', 'filterable' => true, 'order' => 2]);
        $this->define('has_elevator', 'accessibility', 'BOOLEAN', 'مصعد', 'Elevator', ['icon' => 'elevator', 'filterable' => true, 'order' => 3]);

        $this->define('has_parking', 'parking', 'BOOLEAN', 'موقف سيارات', 'Parking', ['icon' => 'car', 'filterable' => true, 'order' => 0]);
        $this->define('parking_spaces', 'parking', 'NUMBER', 'عدد المواقف', 'Parking Spaces', ['icon' => 'car', 'unit' => 'space', 'filterable' => true, 'order' => 1]);
        $this->define('has_ev_charging', 'parking', 'BOOLEAN', 'شاحن سيارات كهربائية', 'EV Charging', ['icon' => 'bolt', 'filterable' => true, 'order' => 2]);
        $this->define('parking_type', 'parking', 'ENUM', 'نوع الموقف', 'Parking Type', ['icon' => 'car', 'filterable' => true, 'order' => 3]);
    }

    protected function define(string $key, string $group, string $type, string $labelAr, string $labelEn, array $options = []): void
    {
        AttributeDefinition::updateOrCreate(
            ['key' => $key],
            [
                'value_type' => $type,
                'group_id' => $this->groupIds[$group],
                'icon' => $options['icon'] ?? null,
                'unit_code' => $options['unit'] ?? null,
                'is_required' => false,
                'is_filterable' => $options['filterable'] ?? true,
                'is_searchable' => $options['searchable'] ?? true,
                'is_displayable' => true,
                'display_order' => $options['order'] ?? 0,
                'is_active' => true,
                'translations_data' => [
                    'ar' => ['key' => $labelAr],
                    'en' => ['key' => $labelEn],
                ],
            ],
        );
    }
}
