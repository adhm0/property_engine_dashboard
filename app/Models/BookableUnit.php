<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BookableUnit extends Model
{
    use HasFactory;
    use HasTranslations;

    public static bool $syncingAttributes = false;

    protected array $translatable = ['name'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'property_id',
        'unit_type_id',
        'name',
        'capacity',
        'base_price',
        'offer_price',
        'status',
        'filter_attributes',
    ];

    protected $casts = [
        'capacity' => 'int',
        'base_price' => 'decimal:2',
        'offer_price' => 'decimal:2',
        'status' => 'string',
        'filter_attributes' => 'array',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function unitType()
    {
        return $this->belongsTo(BookableUnitType::class, 'unit_type_id');
    }

    public function attributeValues()
    {
        return $this->hasMany(BookableUnitAttributeValue::class, 'unit_id');
    }

    public function applicableAttributes(): Collection
    {
        if (blank($this->unit_type_id)) {
            return collect();
        }

        return UnitTypeAttribute::query()
            ->with(['attribute.options'])
            ->where('unit_type_id', $this->unit_type_id)
            ->whereHas('attribute', fn ($query) => $query->where('is_active', true))
            ->orderBy('sort_order')
            ->get();
    }

    public function attributeValuesForForm(): array
    {
        return $this->attributeValues()
            ->get()
            ->mapWithKeys(fn (BookableUnitAttributeValue $value) => [
                $value->attribute_id => [
                    'value_string' => $value->value_string,
                    'value_number' => $value->value_number,
                    'value_boolean' => $value->value_boolean,
                    'value_date' => $value->value_date?->format('Y-m-d H:i:s'),
                    'value_json' => $value->value_json,
                    'option_id' => $value->option_id,
                ],
            ])
            ->all();
    }

    public function syncAttributeValues(array $values): void
    {
        static::$syncingAttributes = true;

        try {
            $applicableAttributes = $this->applicableAttributes();
            $applicableIds = $applicableAttributes->pluck('attribute_id')->all();

            if (empty($applicableIds)) {
                $this->attributeValues()->delete();
            } else {
                $this->attributeValues()
                    ->whereNotIn('attribute_id', $applicableIds)
                    ->delete();
            }

            foreach ($applicableAttributes as $unitTypeAttribute) {
                $definition = $unitTypeAttribute->attribute;
                $input = (array) ($values[$definition->id] ?? []);
                $payload = $this->attributeValuePayload($definition, $input);

                if ($payload === null) {
                    $this->attributeValues()
                        ->where('attribute_id', $definition->id)
                        ->delete();

                    continue;
                }

                $this->attributeValues()->updateOrCreate(
                    ['attribute_id' => $definition->id],
                    $payload,
                );
            }
        } finally {
            static::$syncingAttributes = false;
        }

        $this->rebuildFilterAttributes();
    }

    public function rebuildFilterAttributes(): array
    {
        $filters = [];

        $values = $this->attributeValues()
            ->with(['attribute', 'option'])
            ->get()
            ->keyBy('attribute_id');

        foreach ($this->applicableAttributes() as $unitTypeAttribute) {
            if (! $unitTypeAttribute->is_filterable) {
                continue;
            }

            $definition = $unitTypeAttribute->attribute;
            $value = $values->get($definition->id);

            if (! $value) {
                continue;
            }

            $filterValue = match ($definition->value_type) {
                'NUMBER' => $value->value_number !== null ? (float) $value->value_number : null,
                'BOOLEAN' => $value->value_boolean,
                'DATE' => $value->value_date?->toIso8601String(),
                'ENUM' => $value->option?->value,
                'JSON' => $value->value_json,
                default => $value->value_string,
            };

            if ($filterValue !== null) {
                $filters[$definition->key] = $filterValue;
            }
        }

        $this->forceFill(['filter_attributes' => $filters])->saveQuietly();

        return $filters;
    }

    protected function attributeValuePayload(AttributeDefinition $definition, array $input): ?array
    {
        $payload = [
            'value_string' => null,
            'value_number' => null,
            'value_boolean' => null,
            'value_date' => null,
            'value_json' => null,
            'option_id' => null,
        ];

        $hasValue = match ($definition->value_type) {
            'BOOLEAN' => array_key_exists('value_boolean', $input),
            'NUMBER' => filled($input['value_number'] ?? null),
            'DATE' => filled($input['value_date'] ?? null),
            'ENUM' => filled($input['option_id'] ?? null),
            'JSON' => filled($input['value_json'] ?? null),
            default => filled($input['value_string'] ?? null),
        };

        if (! $hasValue) {
            return null;
        }

        return match ($definition->value_type) {
            'NUMBER' => [...$payload, 'value_number' => $input['value_number']],
            'BOOLEAN' => [...$payload, 'value_boolean' => (bool) $input['value_boolean']],
            'DATE' => [...$payload, 'value_date' => $input['value_date']],
            'ENUM' => [...$payload, 'option_id' => $input['option_id']],
            'JSON' => [...$payload, 'value_json' => $input['value_json']],
            default => [...$payload, 'value_string' => $input['value_string']],
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

        static::saved(function (self $model) {
            if (! static::$syncingAttributes) {
                $model->rebuildFilterAttributes();
            }
        });
    }
}
