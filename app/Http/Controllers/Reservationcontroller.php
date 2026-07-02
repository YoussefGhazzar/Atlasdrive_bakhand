<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class ReservationController extends Controller
{
    // GET /cars/{voiture}  — public car detail + booking form
    public function show(Voiture $voiture)
    {
        $voiture->load(['category', 'agency']);

        return Inertia::render('Dashboard/Client/Cardetail', [
            'car' => [
                'id'             => $voiture->id,
                'marque'         => $voiture->marque,
                'modele'         => $voiture->modele,
                'annee'          => $voiture->annee,
                'prix_par_jour'  => $voiture->prix_par_jour,
                'nb_places'      => $voiture->nb_places,
                'transmission'   => $voiture->transmission,
                'carburant'      => $voiture->carburant,
                'couleur'        => $voiture->couleur,
                'image' => ImageUrlResolver::toPublicUrl($voiture->image),
                'disponible'     => $voiture->disponible,
                'description'    => $voiture->description,
                'city'           => $voiture->agency?->city,
                'category'       => $voiture->category ? ['name' => $voiture->category->name] : null,
                'agency'         => $voiture->agency  ? ['name' => $voiture->agency->name]    : null,
            ],
            
        ]);
    }

    // POST /reservations  — requires auth (client)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'voiture_id' => ['required', 'exists:voitures,id'],
            'date_debut' => ['required', 'date', 'after_or_equal:today'],
            'date_fin'   => ['required', 'date', 'after:date_debut'],
            'notes'      => ['nullable', 'string', 'max:500'],
        ]);

        $voiture = Voiture::findOrFail($validated['voiture_id']);

        if (!$voiture->disponible) {
            return back()->withErrors(['date_debut' => 'This vehicle is no longer available.']);
        }

        // Prevent overlapping reservations for the same car
        $overlap = Reservation::where('voiture_id', $voiture->id)
            ->whereIn('statut', ['en_attente', 'confirmee', 'active'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('date_debut', [$validated['date_debut'], $validated['date_fin']])
                  ->orWhereBetween('date_fin', [$validated['date_debut'], $validated['date_fin']])
                  ->orWhere(function ($q2) use ($validated) {
                      $q2->where('date_debut', '<=', $validated['date_debut'])
                         ->where('date_fin', '>=', $validated['date_fin']);
                  });
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors(['date_debut' => 'This vehicle is already booked for some of these dates.']);
        }

        $days  = Carbon::parse($validated['date_debut'])->diffInDays($validated['date_fin']);
        $total = $days * $voiture->prix_par_jour;

        $reservation = Reservation::create([
            'user_id'    => auth()->id(),
            'voiture_id' => $voiture->id,
            'agency_id'  => $voiture->agency_id,
            'date_debut' => $validated['date_debut'],
            'date_fin'   => $validated['date_fin'],
            'prix_total' => $total,
            'statut'     => 'en_attente',
            'notes'      => $validated['notes'] ?? null,
        ]);

        return redirect()->route('client.bookings')
            ->with('success', 'Reservation request sent! Waiting for agency confirmation.');
    }
}