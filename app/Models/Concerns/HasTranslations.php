<?php

namespace App\Models\Concerns;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTranslations
{
    protected array $pendingTranslations = [];

    public static function bootHasTranslations(): void
    {
        static::saved(function (self $model): void {
            $model->syncTranslations($model->pendingTranslations);
            $model->pendingTranslations = [];
        });

        static::deleted(function (self $model): void {
            $model->translations()->delete();
        });
    }

    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'entity');
    }

    public function getFillable(): array
    {
        return array_values(array_unique([...parent::getFillable(), 'translations_data']));
    }

    public function getArrayableAppends(): array
    {
        return array_values(array_unique([...parent::getArrayableAppends(), 'translations_data']));
    }

    public function getTranslatableFields(): array
    {
        return property_exists($this, 'translatable') ? $this->translatable : [];
    }

    public function getTranslationsDataAttribute(): array
    {
        return $this->pendingTranslations ?: $this->translationsForForm();
    }

    public function setTranslationsDataAttribute(mixed $value): void
    {
        $this->pendingTranslations = is_array($value) ? $value : [];
    }

    public function translationsForForm(): array
    {
        $fields = $this->getTranslatableFields();

        if (empty($fields)) {
            return [];
        }

        $existing = $this->translations()
            ->get()
            ->keyBy(fn (Translation $translation): string => $translation->language_code.'|'.$translation->field);

        $result = [];

        foreach ($this->activeLanguageCodes() as $code) {
            foreach ($fields as $field) {
                $translation = $existing->get($code.'|'.$field);

                $result[$code][$field] = $translation?->value ?? $this->getAttribute($field);
            }
        }

        return $result;
    }

    public function translation(string $field, ?string $languageCode = null): ?string
    {
        $languageCode ??= Language::query()->where('is_default', true)->value('code');

        if (blank($languageCode)) {
            return null;
        }

        $value = $this->translations()
            ->where('field', $field)
            ->where('language_code', $languageCode)
            ->value('value');

        return $value ?? $this->getAttribute($field);
    }

    public function syncTranslations(array $values = []): void
    {
        $fields = $this->getTranslatableFields();

        if (empty($fields)) {
            return;
        }

        foreach ($this->activeLanguageCodes() as $code) {
            foreach ($fields as $field) {
                $hasExplicitValue = array_key_exists($field, (array) data_get($values, $code, []));
                $fallback = $this->getAttribute($field);

                if ($hasExplicitValue) {
                    $value = data_get($values, $code.'.'.$field);

                    if (blank($value)) {
                        $value = $fallback;
                    }

                    if (blank($value)) {
                        continue;
                    }

                    $this->translations()->updateOrCreate(
                        ['field' => $field, 'language_code' => $code],
                        ['value' => $value],
                    );

                    continue;
                }

                if (blank($fallback)) {
                    continue;
                }

                $this->translations()->firstOrCreate(
                    ['field' => $field, 'language_code' => $code],
                    ['value' => $fallback],
                );
            }
        }
    }

    protected function activeLanguageCodes(): array
    {
        return Language::query()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->pluck('code')
            ->all();
    }
}
