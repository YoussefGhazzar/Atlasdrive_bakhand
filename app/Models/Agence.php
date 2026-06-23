<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    protected $fillable = ['nom','prenom','nom_agence','ville', 'address', 'telephone', 'email', 'description', 'user_id', 'status'];  
    protected $hidden = ['password', 'confirm_password'];  
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function voitures()
    {
        return $this->hasMany(Voiture::class, 'agency_id');
    }
    public function reservations()
    {
        return $this->hasManyThrough(Reservation::class, Voiture::class);
    }
}
