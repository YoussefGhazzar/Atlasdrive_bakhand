<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgencyRegisterController extends Controller
{
     public function store(Request $request)
    {
        $data = $request->validate([
            'agencyName' => 'required|string|max:255',
            'city'       => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'firstName'  => 'required|string|max:255',
            'lastName'   => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|string|max:20',
            'password'   => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $data['firstName'].' '.$data['lastName'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'],
        ]);

        $agency = Agence::create([
            'user_id' => $user->id,
            'name'    => $data['agencyName'],
            'city'    => $data['city'],
            'address' => $data['address'],
            'phone'   => $data['phone'],
        ]);

        Auth::login($user);

        return redirect('/agency/dashboard');
        return response()->json(['message' => 'Agency registered successfully'], 201);
    }
}
