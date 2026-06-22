<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use App\Models\Category;
use Inertia\Inertia;

class FleetController extends Controller
{
    public function index()
    {
        $cars = Voiture::with(['category', 'agency'])
            ->get()
            ->map(fn($v) => [
                'id'           => $v->id,
                'name'         => $v->marque . ' ' . $v->modele,
                'brand'        => $v->marque,
                'year'         => $v->annee,
                // ✅ use ?-> instead of -> so it doesn't crash if category is null
                'category'     => $v->category?->name ?? 'Other',
                'pricePerDay'  => (float) $v->prix_par_jour,
                'seats'        => $v->nb_places,
                'fuel'         => match($v->carburant) {
                    'essence'    => 'Petrol',
                    'diesel'     => 'Diesel',
                    'electrique' => 'Electric',
                    'hybride'    => 'Hybrid',
                    // ✅ default catches any unexpected/null value instead of crashing
                    default      => $v->carburant ? ucfirst($v->carburant) : 'Petrol',
                },
                'transmission' => $v->transmission === 'manuelle' ? 'Manual' : 'Automatic',
                'doors'        => 4,
                'rating'       => 4.5,
                'reviews'      => 0,
                'available'    => (bool) $v->disponible,
                'ac'           => true,
                                'image' => $v->image ? asset('/' . ltrim($v->image, '/')) : 'default-car.png',

            ]);

        $categories = Category::all()->map(fn($c) => [
            'label' => $c->name,
            'value' => $c->name,
            'count' => Voiture::where('category_id', $c->id)->count(),
        ]);

        return Inertia::render('Fleet', [
            'cars'       => $cars,
            'categories' => $categories,
        ]);
    }
}