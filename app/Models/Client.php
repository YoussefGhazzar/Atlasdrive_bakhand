<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['nom', 'prenom', 'email', 'password', 'confirm_password', 'telephone', 'ville', 'address', 'numero_permis', 'date_expiration_permis'];  
    protected $hidden = ['password', 'confirm_password'];
}
