<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;
use Spatie\Permission\Traits\HasRoles;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Dashboard/AdminDashboard');
        return response()->json(['message' => 'Admin dashboard'], 200);
    }
    public function overview()
    {
        return Inertia::render('Dashboard/Admin/Overview', [
            'stats' => [],
        ]);
    }
 
    // GET /admin/agencies  →  Pages/Dashboard/Admin/Agencies.vue
    public function agencies()
    {
        $agencies = User::role('agence')
        ->with('agence') 
        ->get()
            ->map(fn($user) => [
                'name' => $user->agence?->nom_agence ?? 'N/A',
                'email' => $user->agence?->email ?? 'N/A',
                'city' => $user->agence?->ville ?? 'N/A',
                'fleet'    => $user->agence?->fleet_size ?? 0,
                  'rating'   => 4.5, 
                  'revenue'  => 0,
                'status'   => $user->agence?->status   ?? 'Pending',
                'initials' => strtoupper(substr($user->nom, 0, 1) . substr($user->prenom, 0, 1)),
                'color'    => '#0d9488',
            ]);
        
        return Inertia::render('Dashboard/Admin/Agencies', [
            'agencies' => $agencies,
        ]);
    }
 
    // GET /admin/users  →  Pages/Dashboard/Admin/Users.vue
    public function users()
    {
        $users = User::role('client')
        ->get()
            ->map(fn($user) => [
                'name' => $user->nom . ' ' . $user->prenom,
                'email' => $user->email,
                'city' => $user->ville,
                'bookings' => 0,
                'initials' => strtoupper(substr($user->nom, 0, 1) . substr($user->prenom, 0, 1)) ?? 0,
                'spent' => 0,
                'joined' => $user->created_at->format('M Y'),
                'color'    => '#0d9488',
            ]);
        return Inertia::render('Dashboard/Admin/Users', [
            'users' => $users,
        ]);
    }
 
    // GET /admin/bookings  →  Pages/Dashboard/Admin/Bookings.vue
    public function bookings()
    {
        return Inertia::render('Dashboard/Admin/Bookings', [
            'bookings' => [],
        ]);
    }
 
    // GET /admin/reports  →  Pages/Dashboard/Admin/Reports.vue
    public function reports()
    {
        return Inertia::render('Dashboard/Admin/Reports', [
            'revenueByCity'   => [],
            'platformMetrics' => [],
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
