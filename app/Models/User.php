<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory,
        Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        // TODO: Temp
        return true;

        return match ($panel->getId()) {
            // 'admin' => $this->hasRole('admin'),
            'admin' => true,
            'it' => true,
            'ots' => true,
            'mtz' => true,
            default => false,
        };
    }

    public function getFilamentName(): string
    {
        // TODO: Temp
        return 'Specify later';

        return "{$this->first_name} {$this->last_name}";
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
