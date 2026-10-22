<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UnitTypeAttribute extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'unit_type_id',
        'attribute_id',
        'is_required',
        'is_filterable',
        'is_displayable',
        'sort_order',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_filterable' => 'boolean',
        'is_displayable' => 'boolean',
        'sort_order' => 'int',
    ];

    public function unitType()
    {
        return $this->belongsTo(BookableUnitType::class, 'unit_type_id');
    }

    public function attribute()
    {
        return $this->belongsTo(AttributeDefinition::class, 'attribute_id');
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
