<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 'voiture_id', 'agency_id',
        'date_debut', 'date_fin', 'prix_total',
        'statut', 'notes',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
        'prix_total' => 'decimal:2',
    ];

    // ✅ nb_jours calculated in PHP — no SQL virtual column needed
    public function getNbJoursAttribute(): int
    {
        if ($this->date_debut && $this->date_fin) {
            return $this->date_debut->diffInDays($this->date_fin);
        }
        return 0;
    }

    // Status label French → English
    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'Pending',
            'confirmee'  => 'Confirmed',
            'active'     => 'Active',
            'terminee'   => 'Completed',
            'annulee'    => 'Cancelled',
            default      => ucfirst($this->statut),
        };
    }

    // Auto-calculate prix_total before saving
    protected static function booted(): void
    {
        static::saving(function (Reservation $r) {
            if ($r->date_debut && $r->date_fin && $r->voiture) {
                $days = \Carbon\Carbon::parse($r->date_debut)
                    ->diffInDays(\Carbon\Carbon::parse($r->date_fin));
                $r->prix_total = $days * $r->voiture->prix_par_jour;
            }
        });
    }

    public function user()    { return $this->belongsTo(User::class);    }
    public function voiture() { return $this->belongsTo(Voiture::class); }
    public function agency()  { return $this->belongsTo(Agence::class);  }
}