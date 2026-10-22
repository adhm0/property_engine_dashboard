<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;
    use HasTranslations;

    protected array $translatable = ['name', 'description'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'owner_id',
        'property_type_classification_id',
        'district_id',
        'name',
        'description',
        'status',
        'address_line1',
        'address_line2',
        'landmark',
        'postal_code',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'status' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function typeClassification()
    {
        return $this->belongsTo(PropertyTypeClassification::class, 'property_type_classification_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function rules()
    {
        return $this->hasMany(PropertyRule::class);
    }

    public function bookableUnits()
    {
        return $this->hasMany(BookableUnit::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
