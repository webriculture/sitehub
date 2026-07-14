<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Translatable values are stored as {"en": "...", "es": "..."} jsonb.
 * Picking resolves the current app locale, falling back to English,
 * then to any available translation.
 */
final class Translate
{
    public static function pick(array|string|null $value, ?string $locale = null): ?string
    {
        if (! is_array($value)) {
            return $value;
        }

        $locale ??= app()->getLocale();

        $picked = $value[$locale] ?? $value['en'] ?? null;

        if (is_string($picked) && $picked !== '') {
            return $picked;
        }

        foreach ($value as $candidate) {
            if (is_string($candidate) && $candidate !== '') {
                return $candidate;
            }
        }

        return null;
    }
}
