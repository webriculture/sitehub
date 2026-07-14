<?php

declare(strict_types=1);

namespace App\Filament\Concerns;

use App\Tenancy\Tenancy;

/**
 * Gates a Filament resource behind a site feature key. Applies to both
 * navigation registration and direct URL access, so a disabled feature
 * is truly absent — not merely hidden.
 */
trait FeatureGated
{
    public static function shouldRegisterNavigation(): bool
    {
        return Tenancy::current()?->hasFeature(static::feature()) ?? false;
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation() && parent::canAccess();
    }

    abstract public static function feature(): string;
}
