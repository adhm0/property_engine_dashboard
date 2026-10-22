<?php

namespace App\Filament\Support;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class TranslationFields
{
    public static function make(array $fields): Section
    {
        return Section::make('الترجمة')
            ->description('أدخل النص بالعربية والإنجليزية. الحقول الأساسية أعلاه تُستخدم كقيمة احتياطية عند ترك الترجمة فارغة.')
            ->schema([
                Tabs::make('translations_tabs')
                    ->tabs([
                        Tab::make('العربية')
                            ->schema(static::localeFields('ar', $fields, 'العربية')),
                        Tab::make('English')
                            ->schema(static::localeFields('en', $fields, 'English')),
                    ]),
            ])
            ->columnSpanFull();
    }

    protected static function localeFields(string $locale, array $fields, string $localeLabel): array
    {
        return collect($fields)
            ->map(function (array $config, string $field) use ($locale, $localeLabel) {
                $label = ($config['label'] ?? $field)." ({$localeLabel})";

                $component = ($config['type'] ?? 'text') === 'textarea'
                    ? Textarea::make("translations_data.{$locale}.{$field}")
                        ->rows($config['rows'] ?? 3)
                    : TextInput::make("translations_data.{$locale}.{$field}");

                $component->label($label);

                if (isset($config['maxLength'])) {
                    $component->maxLength($config['maxLength']);
                }

                if (isset($config['required'])) {
                    $component->required();
                }

                return $component;
            })
            ->values()
            ->all();
    }
}
