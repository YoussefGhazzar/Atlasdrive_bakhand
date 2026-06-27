<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect each role to its own dashboard
            return match(strtolower(Auth::user()->role)) {
                'admin'  => redirect()->route('admin.dashboard'),
                'agence' => redirect()->route('agency.dashboard'),
                default  => redirect()->route('client.dashboard'), // 'client'
            };
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->onlyInput('email');
    }
}