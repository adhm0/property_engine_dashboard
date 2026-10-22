<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AttributeGroup extends Model
{
    use HasFactory;
    use HasTranslations;

    protected array $translatable = ['code'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'code',
        'icon',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'display_order' => 'int',
        'is_active' => 'boolean',
    ];

    public function attributeDefinitions()
    {
        return $this->hasMany(AttributeDefinition::class, 'group_id');
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
