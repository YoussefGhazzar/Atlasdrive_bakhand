<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Models\Voiture;
use App\Models\Category;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
    {
        $user = auth()->user();
 
        // ── All reservations for this user ──────────────────
        $reservations = $user->reservations()
            ->with(['voiture.category', 'voiture.agency'])
            ->latest()
            ->get();
 
        // ── Active rental (statut = active) ─────────────────
        $active = $reservations->firstWhere('statut', 'active');
 
        $activeRental = null;
        if ($active) {
            $start    = Carbon::parse($active->date_debut);
            $end      = Carbon::parse($active->date_fin);
            $today    = Carbon::today();
            $total    = $start->diffInDays($end);
            $elapsed  = $start->diffInDays($today);
            $progress = $total > 0 ? round(($elapsed / $total) * 100) : 0;
 
            $activeRental = [
                'car'        => $active->voiture->marque . ' ' . $active->voiture->modele,
                'agency'     => $active->voiture->agency->name ?? '',
                'city'       => $active->voiture->agency->city ?? '',
                'startDate'  => $start->format('M j'),
                'returnDate' => $end->format('M j'),
                'daysLeft'   => max(0, $today->diffInDays($end, false)),
                'total'      => $active->prix_total,
                'progress'   => min(100, max(0, $progress)),
                'image'      => $active->voiture->image ?? '',
            ];
        }
 
        // ── Bookings list ────────────────────────────────────
        $bookings = $reservations->map(fn($r) => [
            'id'     => $r->id,
            'car'    => $r->voiture->marque . ' ' . $r->voiture->modele,
            'agency' => $r->voiture->agency->name ?? '',
            'city'   => $r->voiture->agency->city ?? '',
            'dates'  => Carbon::parse($r->date_debut)->format('M j')
                      . '–'
                      . Carbon::parse($r->date_fin)->format('M j'),
            'days'   => Carbon::parse($r->date_debut)->diffInDays($r->date_fin),
            'total'  => $r->prix_total,
            'status' => $r->statut_label,   // uses getStatutLabelAttribute()
            'image'  => $r->voiture->image ?? '',
        ]);
 
        // ── Stats cards ──────────────────────────────────────
        $totalSpent = $reservations->sum('prix_total');
        $totalDays  = $reservations->sum(fn($r) =>
            Carbon::parse($r->date_debut)->diffInDays($r->date_fin)
        );
 
        $stats = [
            [
                'label' => 'Total Bookings',
                'value' => $reservations->count(),
                'color' => '#0d9488',
                'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
            ],
            [
                'label' => 'Total Spent',
                'value' => '$' . number_format($totalSpent, 0),
                'color' => '#6366f1',
                'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
            ],
            [
                'label' => 'Days Rented',
                'value' => $totalDays,
                'color' => '#f59e0b',
                'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
            ],
            [
                'label' => 'Active Now',
                'value' => $reservations->where('statut', 'active')->count(),
                'color' => '#ec4899',
                'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>',
            ],
        ];
 
        return Inertia::render('Dashboard/Client/Overview', [
            'client'       => $user,
            'bookings'     => $bookings,
            'activeRental' => $activeRental,
            'stats'        => $stats,
        ]);
    }

     public function bookings()
    {
        $user = auth()->user();
 
        $bookings = $user->reservations()
            ->with(['voiture.agency'])
            ->latest()
            ->get()
            ->map(fn($r) => [
                'id'     => $r->id,
                'car'    => $r->voiture->marque . ' ' . $r->voiture->modele,
                'agency' => $r->voiture->agency->name ?? '',
                'city'   => $r->voiture->agency->city ?? '',
                'dates'  => Carbon::parse($r->date_debut)->format('M j')
                          . '–'
                          . Carbon::parse($r->date_fin)->format('M j'),
                'days'   => Carbon::parse($r->date_debut)->diffInDays($r->date_fin),
                'total'  => $r->prix_total,
                'status' => $r->statut_label,
                'image'  => $r->voiture->image ?? '',
            ]);
 
        return Inertia::render('Dashboard/Client/Bookings', [
            'client'   => $user,
            'bookings' => $bookings,
        ]);
    }

     public function active()
    {
        $user   = auth()->user();
        $active = $user->reservations()
            ->where('statut', 'active')
            ->with(['voiture.agency'])
            ->latest()
            ->first();
 
        $activeRental = null;
        if ($active) {
            $start    = Carbon::parse($active->date_debut);
            $end      = Carbon::parse($active->date_fin);
            $today    = Carbon::today();
            $total    = $start->diffInDays($end);
            $elapsed  = $start->diffInDays($today);
 
            $activeRental = [
                'car'        => $active->voiture->marque . ' ' . $active->voiture->modele,
                'agency'     => $active->voiture->agency->name ?? '',
                'city'       => $active->voiture->agency->city ?? '',
                'startDate'  => $start->format('M j'),
                'returnDate' => $end->format('M j'),
                'daysLeft'   => max(0, $today->diffInDays($end, false)),
                'total'      => $active->prix_total,
                'progress'   => $total > 0 ? min(100, round(($elapsed / $total) * 100)) : 0,
                'image'      => $active->voiture->image ?? '',
            ];
        }
 
        return Inertia::render('Dashboard/Client/ActiveRental', [
            'client'       => $user,
            'activeRental' => $activeRental,
        ]);
    }

    public function fleet(){
        $cars = Voiture::with(['category', 'agency'])
            ->get()
            ->map(fn($v) => [
                'id'           => $v->id,
                'marque'       => $v->marque,
                'modele'       => $v->modele,
                'annee'        => $v->annee,
                'prix_par_jour'=> $v->prix_par_jour,
                'nb_places'    => $v->nb_places,
                'transmission' => $v->transmission,
                'carburant'    => $v->carburant,
                'couleur'      => $v->couleur,
                'image' => $v->image ? asset('/' . ltrim($v->image, '/')) : 'default-car.png',
                'disponible'   => $v->disponible,
                'city'         => $v->agency?->city,
                'category'     => $v->category ? ['name' => $v->category->name] : null,
                'agency'       => $v->agency  ? ['name' => $v->agency->name]    : null,
            ]);
 
        $categories = Category::select('id', 'name', 'slug')->get();
 
        return Inertia::render('Dashboard/Client/Fleet', [
            'cars'       => $cars,
            'categories' => $categories,
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // 1. Validation
    $data = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|min:6|', 
        'confirm_password' => 'required|same:password',
        'telephone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'ville' => 'required|string|max:255',
        'numero_permis' => 'required|string|max:25',
        'licenseNumber' => 'required|string|max:25',
        'date_expiration_permis' => 'required|date',
    ]);

    $user = User::create([
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'telephone' => $data['telephone'],
        'address' => $data['address'],
        'ville' => $data['ville'],
    ]);
    $user->assignRole(3);
     $token = $user->createToken('api-token')->plainTextToken;

    
    Client::create([
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'confirm_password' => Hash::make($data['password']),
        'telephone' => $data['telephone'],
        'address' => $data['address'],
        'ville' => $data['ville'],
        'numero_permis' => $data['numero_permis'],
        'licenseNumber' => $data['licenseNumber'],
        'date_expiration_permis' => $data['date_expiration_permis'],
                'user_id' => $user->id,

    ]);

  
    return response()->json([
        'message' => 'Client registered successfully',
        'data' => $user,
        'token' => $token,
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
