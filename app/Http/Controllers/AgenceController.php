<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\User;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Reservation;
use App\Support\ImageUrlResolver;
use Carbon\Carbon;

class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // return Inertia::render('Dashboard/AgenceDashboard');
        return Inertia::render('Dashboard/Agency/Overview', [
            'agency' => auth()->user()->agence ?? auth()->user(),
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
    try {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'nom_agence' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',  
            'ville' => 'required|string|max:255',
            'address' => 'required|string|max:255',
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

        $user->assignRole(2); 

        $token = $user->createToken('api-token')->plainTextToken;

        $agence = Agence::create([
            'nom' => $data['nom'], 
            'prenom' => $data['prenom'],
            'nom_agence' => $data['nom_agence'],
            'ville' => $data['ville'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'confirm_password' => Hash::make($data['password']),
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'user_id' => $user->id, 
        ]);

        return response()->json([
            'message' => 'Agence cree avec succes',
            'token' => $token,
            'data' => $agence
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

 private function agencyData()
    {
        $user   = auth()->user();
        $agency = $user->agence ?? $user;
        return $agency;
    }
 
   // GET /agence/dashboard & /agence/overview
public function overview()
{
    $agency = auth()->user()->agence;
 
    // ── Stats cards ──────────────────────────────────────
    $totalRevenue   = Reservation::where('agency_id', $agency->id)
        ->whereIn('statut', ['confirmee', 'active', 'terminee'])
        ->sum('prix_total');
 
    $activeBookings = Reservation::where('agency_id', $agency->id)
        ->whereIn('statut', ['confirmee', 'active'])
        ->count();
 
    $fleetSize = Voiture::where('agency_id', $agency->id)->count();
 
    $stats = [
        [
            'label'  => 'Total Revenue',
            'value'  => '$' . number_format($totalRevenue, 0),
            'change' => '+12%',   // replace with real MoM calc when you have historical data
            'up'     => true,
            'color'  => '#0d9488',
            'icon'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
        ],
        [
            'label'  => 'Active Bookings',
            'value'  => (string) $activeBookings,
            'change' => '+5%',
            'up'     => true,
            'color'  => '#6366f1',
            'icon'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        ],
        [
            'label'  => 'Fleet Size',
            'value'  => (string) $fleetSize,
            'change' => '+2',
            'up'     => true,
            'color'  => '#f59e0b',
            'icon'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="9" width="20" height="9" rx="2"/><path d="M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>',
        ],
        [
            'label'  => 'Avg Rating',
            'value'  => '4.8★',   // replace with real avg when you have a reviews table
            'change' => '+0.2',
            'up'     => true,
            'color'  => '#ec4899',
            'icon'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>',
        ],
    ];
 
    // ── Recent bookings (last 5) ─────────────────────────
    $recentBookings = Reservation::where('agency_id', $agency->id)
        ->with(['voiture', 'user'])
        ->latest()
        ->take(5)
        ->get()
        ->map(fn($r) => [
            'id'          => $r->id,
            'client'      => $r->user->prenom . ' ' . $r->user->nom,
            'initials'    => strtoupper(substr($r->user->prenom, 0, 1) . substr($r->user->nom, 0, 1)),
            'avatarColor' => $this->colorFor($r->user->id),
            'vehicle'     => $r->voiture->marque . ' ' . $r->voiture->modele,
            'dates'       => Carbon::parse($r->date_debut)->format('M j')
                           . '–'
                           . Carbon::parse($r->date_fin)->format('M j'),
            'amount'      => $r->prix_total,
            'status'      => $r->statut_label,
        ]);
 
    return Inertia::render('Dashboard/Agency/Overview', [
        'agency'         => $agency,
        'stats'          => $stats,
        'recentBookings' => $recentBookings,
    ]);
}
 
 public function fleet()
{
    $agency = auth()->user()->agence;
 
    $fleet = Voiture::where('agency_id', $agency->id)
        ->with('category')
        ->latest()
        ->get()
        ->map(fn($v) => [
            'id'              => $v->id,
            'marque'          => $v->marque,
            'modele'          => $v->modele,
            'annee'           => $v->annee,
            'immatriculation' => $v->immatriculation,
            'prix_par_jour'   => $v->prix_par_jour,
            'nb_places'       => $v->nb_places,
            'transmission'    => $v->transmission,
            'carburant'       => $v->carburant,
            'couleur'         => $v->couleur,
            'disponible'      => $v->disponible,
            'category'        => $v->category,
            
            'image'           => ImageUrlResolver::toPublicUrl($v->image),
        ]);
 
    $categories = Category::select('id', 'name')->get();
 
    return Inertia::render('Dashboard/Agency/Fleet', [
        'agency'     => $agency,
        'fleet'      => $fleet, // Safi daba 'fleet' fiha les URLs s-s7a7
        'categories' => $categories,
    ]);
}
 
// POST /agence/fleet
public function storeFleet(Request $request)
{
    $validated = $request->validate([
        'marque'          => ['required', 'string', 'max:50'],
        'modele'          => ['required', 'string', 'max:50'],
        'annee'           => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
        'immatriculation' => ['required', 'string', 'max:20', 'unique:voitures,immatriculation'],
        'category_id'     => ['required', 'exists:categories,id'],
        'prix_par_jour'   => ['required', 'numeric', 'min:0'],
        'nb_places'       => ['nullable', 'integer', 'min:1', 'max:9'],
        'transmission'    => ['required', 'in:manuelle,automatique'],
        'carburant'       => ['required', 'in:essence,diesel,electrique,hybride'],
        'couleur'         => ['nullable', 'string', 'max:30'],
        'image'           => ['nullable', 'image', 'max:4096'],
        'disponible'      => ['nullable'],
    ]);
 
    $imagePath = null;
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('images', 'public');
        $imagePath = 'storage/' . $path;
    }

    // Build the insert array explicitly — no $request->except()
    $data = [
        'agency_id'       => auth()->user()->agence->id,
        'marque'          => $validated['marque'],
        'modele'          => $validated['modele'],
        'annee'           => $validated['annee'],
        'immatriculation' => $validated['immatriculation'],
        'category_id'     => $validated['category_id'],
        'prix_par_jour'   => $validated['prix_par_jour'],
        'nb_places'       => $validated['nb_places'] ?? 5,
        'transmission'    => $validated['transmission'],
        'carburant'       => $validated['carburant'],
        'couleur'         => $validated['couleur'] ?? null,
        'disponible'      => $request->boolean('disponible'),
        'image'           => $imagePath,
    ];
 
 
    Voiture::create($data);
 
    return back()->with('success', 'Vehicle added successfully.');
}
 
// PUT /agence/fleet/{voiture}
public function updateFleet(Request $request, Voiture $voiture)
{
    // Ensure the vehicle belongs to the logged-in agency
    abort_unless($voiture->agency_id === auth()->user()->agence->id, 403);
 
    $request->validate([
        'marque'          => ['required', 'string', 'max:50'],
        'modele'          => ['required', 'string', 'max:50'],
        'annee'           => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
        'immatriculation' => ['required', 'string', 'max:20', 'unique:voitures,immatriculation,' . $voiture->id],
        'category_id'     => ['required', 'exists:categories,id'],
        'prix_par_jour'   => ['required', 'numeric', 'min:0'],
        'nb_places'       => ['nullable', 'integer', 'min:1', 'max:9'],
        'transmission'    => ['required', 'in:manuelle,automatique'],
        'carburant'       => ['required', 'in:essence,diesel,electrique,hybride'],
        'couleur'         => ['nullable', 'string', 'max:30'],
        'image'           => ['nullable', 'image', 'max:4096'],
        'disponible'      => ['boolean'],
    ]);
 
    $data = $request->except('image');
 
    if ($request->hasFile('image')) {
        if ($voiture->image) {
            $oldPath = $voiture->image;
            if (str_starts_with($oldPath, 'storage/')) {
                $oldPath = substr($oldPath, strlen('storage/'));
            }
            Storage::disk('public')->delete($oldPath);
        }
        $path = $request->file('image')->store('images', 'public');
        $data['image'] = 'storage/' . $path;
    }
 
    $voiture->update($data);
 
    return back()->with('success', 'Vehicle updated successfully.');
}
 
// DELETE /agence/fleet/{voiture}
public function destroyFleet(Voiture $voiture)
{
    abort_unless($voiture->agency_id === auth()->user()->agence->id, 403);
 
    if ($voiture->image) {
        $oldPath = $voiture->image;
        if (str_starts_with($oldPath, 'storage/')) {
            $oldPath = substr($oldPath, strlen('storage/'));
        }
        Storage::disk('public')->delete($oldPath);
    }
 
    $voiture->delete();
 
    return back()->with('success', 'Vehicle removed.');
}
    
// GET /agence/bookings  →  Pages/Dashboard/Agency/Bookings.vue
public function bookings()
{
    $agency = auth()->user()->agence;
 
    $bookings = Reservation::where('agency_id', $agency->id)
        ->with(['voiture', 'user'])
        ->latest()
        ->get()
        ->map(fn($r) => [
            'id'          => $r->id,
            'client'      => $r->user->prenom . ' ' . $r->user->nom,
            'initials'    => strtoupper(substr($r->user->prenom, 0, 1) . substr($r->user->nom, 0, 1)),
            'avatarColor' => $this->colorFor($r->user->id),
            'vehicle'     => $r->voiture->marque . ' ' . $r->voiture->modele,
            'pickup'      => Carbon::parse($r->date_debut)->format('M j'),
            'return'      => Carbon::parse($r->date_fin)->format('M j'),
            'days'        => Carbon::parse($r->date_debut)->diffInDays($r->date_fin),
            'total'       => $r->prix_total,
            'status'      => $r->statut_label,   // uses getStatutLabelAttribute()
        ]);
 
    return Inertia::render('Dashboard/Agency/Bookings', [
        'agency'   => $agency,
        'bookings' => $bookings,
    ]);
}
    private function colorFor(int $userId): string
{
    $colors = ['#0d9488', '#6366f1', '#f59e0b', '#ec4899', '#8b5cf6', '#0891b2', '#16a34a'];
    return $colors[$userId % count($colors)];
}
 
   
// GET /agence/earnings  →  Pages/Dashboard/Agency/Earnings.vue
public function earnings()
{
    $agence = auth()->user()->agence;
    abort_unless($agence, 403);
 
    $now        = Carbon::now();
    $thisMonth  = $now->copy()->startOfMonth();
    $lastMonth  = $now->copy()->subMonth()->startOfMonth();
    $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();
 
    // ── Earning cards: This month / Last month / Total this year ──
    $thisMonthRevenue = Reservation::where('agency_id', $agence->id)
        ->whereIn('statut', ['confirmee', 'active', 'terminee'])
        ->where('date_debut', '>=', $thisMonth)
        ->sum('prix_total');
 
    $lastMonthRevenue = Reservation::where('agency_id', $agence->id)
        ->whereIn('statut', ['confirmee', 'active', 'terminee'])
        ->whereBetween('date_debut', [$lastMonth, $lastMonthEnd])
        ->sum('prix_total');
 
    $yearRevenue = Reservation::where('agency_id', $agence->id)
        ->whereIn('statut', ['confirmee', 'active', 'terminee'])
        ->whereYear('date_debut', $now->year)
        ->sum('prix_total');
 
    // % change vs last month (avoid division by zero)
    $changeVsLastMonth = $lastMonthRevenue > 0
        ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100)
        : 0;
 
    $earningCards = [
        [
            'label'  => 'This Month',
            'value'  => number_format($thisMonthRevenue, 0),
            'change' => ($changeVsLastMonth >= 0 ? '+' : '') . $changeVsLastMonth . '%',
            'up'     => $changeVsLastMonth >= 0,
        ],
        [
            'label'  => 'Last Month',
            'value'  => number_format($lastMonthRevenue, 0),
            'change' => '—',
            'up'     => true,
        ],
        [
            'label'  => 'Total ' . $now->year,
            'value'  => number_format($yearRevenue, 0),
            'change' => '+' . round((($yearRevenue ?: 1) / max($yearRevenue, 1)) * 100 - 100) . '%',
            'up'     => true,
        ],
    ];
 
    // ── Revenue by category ──────────────────────────────
    $revenueByCategory = Reservation::where('reservations.agency_id', $agence->id)
        ->whereIn('reservations.statut', ['confirmee', 'active', 'terminee'])
        ->join('voitures', 'voitures.id', '=', 'reservations.voiture_id')
        ->join('categories', 'categories.id', '=', 'voitures.category_id')
        ->selectRaw('categories.name as name, SUM(reservations.prix_total) as revenue')
        ->groupBy('categories.name')
        ->orderByDesc('revenue')
        ->get();
 
    $maxRevenue = $revenueByCategory->max('revenue') ?: 1;
 
    $colors = ['#0d9488', '#6366f1', '#f59e0b', '#10b981', '#8b5cf6', '#ec4899'];
 
    $revenueByCategory = $revenueByCategory->map(function ($row, $i) use ($maxRevenue, $colors) {
        return [
            'name'    => $row->name,
            'revenue' => number_format($row->revenue, 0),
            'pct'     => round(($row->revenue / $maxRevenue) * 100),
            'color'   => $colors[$i % count($colors)],
        ];
    });
 
    return Inertia::render('Dashboard/Agency/Earnings', [
        'agency'            => $agence,
        'earningCards'      => $earningCards,
        'revenueByCategory' => $revenueByCategory,
    ]);
}
 
    // GET /agence/settings  → Pages/Dashboard/Agency/Settings.vue
    public function settings()
    {
        return Inertia::render('Dashboard/Agency/Settings', [
            'agency' => $this->agencyData(),
        ]);
    }
 
    // PATCH /agence/settings
    public function updateSettings(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:150'],
            'email'   => ['nullable', 'email'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'city'    => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:200'],
        ]);
 
        auth()->user()->agence?->update(
            $request->only('name', 'email', 'phone', 'city', 'address')
        );
 
        return back()->with('success', 'Settings saved.');
    }

  
 public function updateBookingStatus(Request $request, Reservation $reservation)
    {
        $agence = auth()->user()->agence;
 
        if (!$agence) {
            abort(403, 'No agency associated with this account.');
        }
 
        abort_unless($reservation->agency_id === $agence->id, 403);
 
        $request->validate([
            'statut' => ['required', 'in:en_attente,confirmee,active,terminee,annulee'],
        ]);
 
        $allowedTransitions = [
            'en_attente' => ['confirmee', 'annulee'],
            'confirmee'  => ['active', 'annulee'],
            'active'     => ['terminee'],
            'terminee'   => [],
            'annulee'    => [],
        ];
 
        if (!in_array($request->statut, $allowedTransitions[$reservation->statut] ?? [])) {
            return back()->withErrors([
                'statut' => "Cannot change status from {$reservation->statut} to {$request->statut}.",
            ]);
        }
 
        $reservation->update(['statut' => $request->statut]);
 
        if ($request->statut === 'active') {
            $reservation->voiture->update(['disponible' => false]);
        }
 
        if ($request->statut === 'terminee') {
            $reservation->voiture->update(['disponible' => true]);
        }
 
        return back()->with('success', 'Booking status updated.');
    }
 
    /**
     * Display the specified resource.
     */
    public function show(Agence $agence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agence $agence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agence $agence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agence $agence)
    {
        //
    }
}
