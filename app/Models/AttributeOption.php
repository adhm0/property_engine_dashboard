<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AttributeOption extends Model
{
    use HasFactory;
    use HasTranslations;

    protected array $translatable = ['value'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'attribute_id',
        'value',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'int',
        'is_active' => 'boolean',
    ];

    public function attribute()
    {
        return $this->belongsTo(AttributeDefinition::class, 'attribute_id');
    }

    public function attributeValues()
    {
        return $this->hasMany(BookableUnitAttributeValue::class, 'option_id');
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
