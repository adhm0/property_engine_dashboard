<?php

namespace App\Filament\Widgets;

use App\Models\BookableUnit;
use App\Models\City;
use App\Models\District;
use App\Models\Property;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PropertyEngineStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $propertiesCount = Property::count();
        $unitsCount = BookableUnit::count();
        $citiesCount = City::count();
        $districtsCount = District::count();
        $usersCount = User::count();

        return [
            Stat::make('إجمالي العقارات', (string) $propertiesCount)
                ->description('العقارات المسجلة')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('success')
                ->chart([2, 4, 7, 10, 15, 22, 28]),

            Stat::make('الوحدات القابلة للحجز', (string) $unitsCount)
                ->description('الوحدات المتاحة للإيجار')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('info')
                ->chart([5, 12, 18, 25, 34, 45, 55]),

            Stat::make('الشبكة الجغرافية', "{$citiesCount} مدينة / {$districtsCount} حي")
                ->description('المناطق والمناطق الفرعية النشطة')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('warning'),

            Stat::make('المستخدمون والملاك', (string) $usersCount)
                ->description('حسابات النظام والملاك')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
        ];
    }
}
