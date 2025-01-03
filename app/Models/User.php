<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable implements HasAvatar, FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Apply a global scope to exclude nonactive users.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Apply a global scope to exclude nonactive users
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', '!=', 'BLOCKED');
        });
    }


    /**
     * Determine if the user can access a specific panel based on their role.
     *
     * @param Panel $panel The panel to check access for.
     * @return bool True if the user has access to the panel, false otherwise.
     */

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'SISWA' && $panel->getId() == 'siswa' || $this->role === 'ADMIN' && $panel->getId() == 'admin' || $this->role === 'KEPSEK' && $panel->getId() == 'kepsek';
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
            'password' => 'hashed',
        ];
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url("$this->avatar_url") : '/default_pp.png';
    }

    /**
     * Summary of isActive
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'ACTIVE';
    }

    public function calonSiswa()
    {
        return $this->hasOne(CalonSiswa::class);
    }
}
