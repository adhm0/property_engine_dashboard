<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AttributeDefinition extends Model
{
    use HasFactory;
    use HasTranslations;

    protected array $translatable = ['key'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'key',
        'value_type',
        'group_id',
        'icon',
        'unit_code',
        'is_required',
        'is_filterable',
        'is_searchable',
        'is_displayable',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'value_type' => 'string',
        'is_required' => 'boolean',
        'is_filterable' => 'boolean',
        'is_searchable' => 'boolean',
        'is_displayable' => 'boolean',
        'display_order' => 'int',
        'is_active' => 'boolean',
    ];

    public function group()
    {
        return $this->belongsTo(AttributeGroup::class, 'group_id');
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id');
    }

    public function unitTypeAttributes()
    {
        return $this->hasMany(UnitTypeAttribute::class, 'attribute_id');
    }

    public function attributeValues()
    {
        return $this->hasMany(BookableUnitAttributeValue::class, 'attribute_id');
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
