<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class voiture extends Model
{
    protected $fillable = [
        'agency_id',
        'category_id',
        'marque',
        'modele',
        'annee',
        'immatriculation',
        'couleur',
        'image',
        'prix_par_jour',
        'disponible',
    ];

    public function agency()
    {
        return $this->belongsTo(Agence::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
