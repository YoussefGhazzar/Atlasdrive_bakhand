<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Agence;
use App\Models\reservation;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'addresse',
        'ville',
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

    public function agence()
    {
        return $this->hasOne(Agence::class, 'user_id');
    }
    
    public function reservations()
{
    return $this->hasMany(reservation::class);
    }
} 