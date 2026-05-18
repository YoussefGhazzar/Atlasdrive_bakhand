<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Handle login and redirect by role.
     */
    public function store(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    $request->session()->regenerate();

    // 🔥 L-ISLA7 HNA: Kheddem Spatie bach t-jib smiyt le role
    $user = Auth::user();
    
    if ($user->hasRole('admin')) {
        return redirect()->intended(route('admin.dashboard'));
    } elseif ($user->hasRole('agence')) {
        return redirect()->intended(route('agence.dashboard'));
    } elseif ($user->hasRole('client')) {
        return redirect()->intended(route('client.dashboard'));
    }

    // Ila mal9a 3ndou walo
    return $this->invalidRole();
}
    /**
     * Log the user out.
     */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('Auth/login');
    }

    /**
     * Handle unknown/missing role.
     */
    private function invalidRole()
    {
        Auth::logout();

        return redirect()->route('Auth/login')->withErrors([
            'email' => 'Your account does not have a valid role. Contact support.',
        ]);
    }
}