<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
    {
        $user = auth()->user();
 
        return Inertia::render('Dashboard/Client/Overview', [
            'client'       => $user,
            'bookings'     => [],
            'activeRental' => null,
            'stats'        => [],
        ]);
    }

     public function bookings()
    {
        $user = auth()->user();
 
        return Inertia::render('Dashboard/Client/Bookings', [
            'client'   => $user,
            'bookings' => [],
        ]);
    }

     public function active()
    {
        return Inertia::render('Dashboard/Client/ActiveRental', [
            'client'       => auth()->user(),
            'activeRental' => null,
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
