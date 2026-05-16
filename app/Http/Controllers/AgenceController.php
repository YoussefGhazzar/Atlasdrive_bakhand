<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // return Inertia::render('Dashboard/AgenceDashboard');
        return Inertia::render('Dashboard/AgenceDashboard');
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
