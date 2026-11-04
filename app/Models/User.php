<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'role_id',
    'name',
    'alias',
    'email',
    'recovery_email',
    'password',
    'phone',
    'identity_number',
    'instagram_handle',
    'profile_photo_path',
    'address',
    'address_line_2',
    'city',
    'state',
    'country_id',
    'postal_code',
    'birth_date',
    'bio',
    'terms_accepted',
    'terms_accepted_at',
    'is_admin',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_verified' => 'boolean',
            'is_worker_organization' => 'boolean',
            'terms_accepted' => 'boolean',
            'terms_accepted_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'birth_date' => 'date',
            'identity_number' => 'encrypted',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin || $this->role?->slug === 'administrator';
    }
}
