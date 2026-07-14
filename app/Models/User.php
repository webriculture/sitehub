<?php

declare(strict_types=1);

namespace App\Models;

use App\Tenancy\Tenancy;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// is_super_admin is deliberately NOT fillable — set it explicitly, never from input.
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
final class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_super_admin' => 'boolean',
        ];
    }

    public function sites(): BelongsToMany
    {
        return $this->belongsToMany(Site::class)->withTimestamps();
    }

    /**
     * Panel access: super admins everywhere; everyone else only on the
     * domains of sites they belong to.
     *
     * Filament checks this from its Authenticate middleware, which can run
     * before ResolveSite — so fall back to resolving the site from the
     * request host rather than relying on middleware order.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->is_super_admin) {
            return true;
        }

        // Always derive from the request host — a Tenancy binding left over
        // from a previous request in the same process must never leak into
        // an access decision for a different domain.
        $site = Domain::query()
            ->where('hostname', strtolower(request()->getHost()))
            ->first()
            ?->site;

        return $site !== null && $this->sites()->whereKey($site->getKey())->exists();
    }
}
