<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Translation extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'entity_type',
        'entity_id',
        'field',
        'language_code',
        'value',
    ];

    protected $casts = [
        'entity_type' => 'string',
        'field' => 'string',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }

    public function entity()
    {
        return $this->morphTo();
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
