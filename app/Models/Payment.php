<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
    'agence_id', 'user_id', 'plan', 'billing_cycle', 
    'amount', 'cardholder_name', 'address', 'city', 
    'postal_code', 'status'
];

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
