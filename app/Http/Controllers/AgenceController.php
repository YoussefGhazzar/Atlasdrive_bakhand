<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\User;
use App\Models\voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Reservation;


class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // return Inertia::render('Dashboard/AgenceDashboard');
        return Inertia::render('Dashboard/Agency/Overview', [
            'agency' => auth()->user()->agency ?? auth()->user(),
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
        $agency = $user->agency ?? $user;
        return $agency;
    }
 
    // GET /agence/dashboard  → Pages/Dashboard/Agency/Overview.vue
    public function overview()
    {
        return Inertia::render('Dashboard/Agency/Overview', [
            'agency'         => $this->agencyData(),
            'stats'          => [],
            'recentBookings' => [],
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
            
            'image'           => $v->image 
                ? asset('/' . ltrim($v->image, '/')) 
                : '/images/default-car.png',
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
    ];
 
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('images', 'public');
    }
 
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
            Storage::disk('public')->delete($voiture->image);
        }
        $data['image'] = $request->file('image')->store('images', 'public');
    }
 
    $voiture->update($data);
 
    return back()->with('success', 'Vehicle updated successfully.');
}
 
// DELETE /agence/fleet/{voiture}
public function destroyFleet(Voiture $voiture)
{
    abort_unless($voiture->agency_id === auth()->user()->agence->id, 403);
 
    if ($voiture->image) {
        Storage::disk('public')->delete($voiture->image);
    }
 
    $voiture->delete();
 
    return back()->with('success', 'Vehicle removed.');
}
    // GET /agence/bookings  → Pages/Dashboard/Agency/Bookings.vue
    public function bookings()
    {
        return Inertia::render('Dashboard/Agency/Bookings', [
            'agency'   => $this->agencyData(),
            'bookings' => [],
        ]);
    }
 
    // GET /agence/earnings  → Pages/Dashboard/Agency/Earnings.vue
    public function earnings()
    {
        return Inertia::render('Dashboard/Agency/Earnings', [
            'agency'            => $this->agencyData(),
            'earningCards'      => [],
            'revenueByCategory' => [],
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
