<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser; 
use Filament\Models\Contracts\HasName;
use Filament\Panel; 

#[Fillable(['email', 'password', 'role', 'google_id', 'email_verified_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function getFilamentName(): string
    {
        return $this->operator?->name ?? $this->email;
    }

    public function operator() {
        return $this->hasOne(Operator::class, 'user_id', 'id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // return true;
        return $this->role === 'admin';
    }
}