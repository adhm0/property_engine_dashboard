<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PropertyType extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function propertyTypeClassifications()
    {
        return $this->hasMany(PropertyTypeClassification::class, 'property_type_id');
    }

    public function classifications()
    {
        return $this->belongsToMany(PropertyClassification::class, 'property_type_classifications', 'property_type_id', 'classification_id')
            ->wherePivot('is_active', true)
            ->withTimestamps();
    }

    public function properties()
    {
        return $this->hasManyThrough(Property::class, PropertyTypeClassification::class, 'property_type_id', 'district_id', 'id', 'property_type_classification_id')
            ->wherePivot('is_active', true);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string)Str::uuid();
            }
        });
    }
}
