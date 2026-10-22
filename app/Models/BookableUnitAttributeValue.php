<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookableUnitAttributeValue extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'unit_id',
        'attribute_id',
        'value_string',
        'value_number',
        'value_boolean',
        'value_date',
        'value_json',
        'option_id',
    ];

    protected $casts = [
        'value_number' => 'decimal:2',
        'value_boolean' => 'boolean',
        'value_date' => 'datetime',
        'value_json' => 'array',
    ];

    public function unit()
    {
        return $this->belongsTo(BookableUnit::class, 'unit_id');
    }

    public function attribute()
    {
        return $this->belongsTo(AttributeDefinition::class, 'attribute_id');
    }

    public function option()
    {
        return $this->belongsTo(AttributeOption::class, 'option_id');
    }

    public function getValueDisplayAttribute(): ?string
    {
        return match ($this->attribute?->value_type) {
            'BOOLEAN' => $this->value_boolean ? 'نعم' : 'لا',
            'NUMBER' => $this->value_number !== null ? (string) $this->value_number : null,
            'DATE' => $this->value_date?->format('Y-m-d H:i'),
            'ENUM' => $this->option?->translation('value') ?? $this->option?->value,
            'JSON' => $this->value_json ? json_encode($this->value_json, JSON_UNESCAPED_UNICODE) : null,
            default => $this->value_string,
        };
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });

        static::saving(function (self $model) {
            $definition = AttributeDefinition::find($model->attribute_id);

            if (! $definition) {
                return;
            }

            $values = [
                'value_string' => null,
                'value_number' => null,
                'value_boolean' => null,
                'value_date' => null,
                'value_json' => null,
                'option_id' => null,
            ];

            $column = match ($definition->value_type) {
                'NUMBER' => 'value_number',
                'BOOLEAN' => 'value_boolean',
                'DATE' => 'value_date',
                'ENUM' => 'option_id',
                'JSON' => 'value_json',
                default => 'value_string',
            };

            $values[$column] = $model->{$column};

            foreach ($values as $key => $value) {
                $model->{$key} = $value;
            }

            if ($definition->value_type === 'ENUM' && filled($model->option_id)) {
                $validOption = AttributeOption::query()
                    ->whereKey($model->option_id)
                    ->where('attribute_id', $definition->id)
                    ->exists();

                if (! $validOption) {
                    throw ValidationException::withMessages([
                        'option_id' => 'الخيار المحدد لا يتبع هذه السمة.',
                    ]);
                }
            }

            $unit = BookableUnit::find($model->unit_id);

            if ($unit && ! $unit->applicableAttributes()->contains('attribute_id', $definition->id)) {
                throw ValidationException::withMessages([
                    'attribute_id' => 'هذه السمة غير مخصصة لنوع هذه الوحدة.',
                ]);
            }
        });

        static::saved(fn (self $model) => $model->refreshUnitFilters());
        static::deleted(fn (self $model) => $model->refreshUnitFilters());
    }

    protected function refreshUnitFilters(): void
    {
        if (BookableUnit::$syncingAttributes) {
            return;
        }

        BookableUnit::find($this->unit_id)?->rebuildFilterAttributes();
    }
}
