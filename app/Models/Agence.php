<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    protected $fillable = ['nom','prenom','nom_agence','ville', 'address', 'telephone', 'email', 'description', 'user_id'];  
    protected $hidden = ['password', 'confirm_password'];  
}
