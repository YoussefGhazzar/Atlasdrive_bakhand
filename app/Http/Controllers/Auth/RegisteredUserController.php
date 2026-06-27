<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function client(): Response
    {
        return Inertia::render('Auth/RegisterClient');
    }
    public function agency(): Response
    {
        return Inertia::render('Auth/RegisterAgency');
    }

     public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|confirmed',
        'role' => 'required'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $request->role, 
    ]);

    
    Auth::login($user);

    return redirect()->route('agency.select-plan');
}

 public function registerAgency(Request $request)
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

        // 1. Create User
        $user = User::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'telephone' => $data['telephone'],
            'address' => $data['address'],
            'ville' => $data['ville'],
        ]);

        // 2. Assign Role
        $user->assignRole(2); 

        $agence = Agence::create([
            'nom_agence' => $data['nom_agence'],
            'nom' => $data['nom'], 
            'prenom' => $data['prenom'],
            'ville' => $data['ville'],
            'address' => $data['address'],
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'user_id' => $user->id, 
        ]);

        // 4. LOGIN D-AROURI BACH L-MIDDLEWARE AUTH YKHEDEM
        Auth::login($user);
        
      
        return redirect()->route('agency.select-plan')->with('success', 'Agency registered successfully. Please select a plan to continue.');

    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}


public function registerClient(Request $request)
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

  
    return redirect()->route('client.dashboard')->with('success', 'Client registered successfully. You can now log in.');
    
}

}
