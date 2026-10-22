<?php

namespace App\Providers;

use App\Models\AttributeDefinition;
use App\Models\AttributeGroup;
use App\Models\AttributeOption;
use App\Models\BookableUnit;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Property;
use App\Models\PropertyRule;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'COUNTRY' => Country::class,
            'CITY' => City::class,
            'DISTRICT' => District::class,
            'PROPERTY' => Property::class,
            'BOOKABLE_UNIT' => BookableUnit::class,
            'PROPERTY_RULE' => PropertyRule::class,
            'ATTRIBUTE_GROUP' => AttributeGroup::class,
            'ATTRIBUTE_DEFINITION' => AttributeDefinition::class,
            'ATTRIBUTE_OPTION' => AttributeOption::class,
        ]);
    }
}
