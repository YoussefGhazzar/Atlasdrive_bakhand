<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agence;
use App\Models\Voiture;
use App\Models\Reservation;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    // GET /admin/dashboard & /admin/overview
    public function overview()
    {
        $totalRevenue = Reservation::whereIn('statut', ['confirmee', 'active', 'terminee'])
            ->sum('prix_total');

        $totalAgencies = Agence::count();
        $totalUsers    = User::role('client')->count();
        $totalBookings = Reservation::count();

        $stats = [
            [
                'label'  => 'Total Revenue',
                'value'  => '$' . number_format($totalRevenue, 0),
                'change' => '+24%',
                'up'     => true,
                'color'  => '#0d9488',
                'icon'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
            ],
            [
                'label'  => 'Partner Agencies',
                'value'  => (string) $totalAgencies,
                'change' => '+6',
                'up'     => true,
                'color'  => '#6366f1',
                'icon'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>',
            ],
            [
                'label'  => 'Registered Users',
                'value'  => number_format($totalUsers),
                'change' => '+18%',
                'up'     => true,
                'color'  => '#f59e0b',
                'icon'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>',
            ],
            [
                'label'  => 'Total Bookings',
                'value'  => number_format($totalBookings),
                'change' => '+31%',
                'up'     => true,
                'color'  => '#ec4899',
                'icon'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
            ],
        ];

        return Inertia::render('Dashboard/Admin/Overview', [
            'stats' => $stats,
        ]);
    }

    // GET /admin/agencies
    public function agencies()
    {
            $agency = auth()->user()->agence;

        $agencies = Agence::with('user')
            ->withCount('voitures')
            ->get()
            ->map(fn($a) => [
                'id'       => $a->id,
                'name'     => $a->nom_agence,
                'email'    => $a->email,
                'city'     => $a->ville,
                'fleet'    => $a->voitures_count,
                'rating'   => 4.5, // replace once you have reviews
                'revenue'  => round(
                    Reservation::where('agency_id', $a->id)
                        ->whereIn('statut', ['confirmee', 'active', 'terminee'])
                        ->sum('prix_total') / 1000,
                    1
                ),
                'status'   => $a->status ?? 'Pending',
                'initials' => strtoupper(substr($a->prenom ?? $a->nom_agence, 0, 1) . substr($a->nom ?? '', 0, 1)),
                'color'    => $this->colorFor($a->id),
            ]);

        return Inertia::render('Dashboard/Admin/Agencies', [
            'agencies' => $agencies,
        ]);
    }

    // PATCH /admin/agencies/{agence}/status
    public function updateAgencyStatus(Request $request, Agence $agence)
    {
        $request->validate([
            'status' => ['required', 'in:Pending,Verified,Suspended'],
        ]);

        $agence->update(['status' => $request->status]);

        return back()->with('success', 'Agency status updated.');
    }

    // GET /admin/users
    public function users()
    {
        $users = User::role('client')
            ->withCount('reservations')
            ->get()
            ->map(fn($u) => [
                'id'       => $u->id,
                'name'     => $u->prenom . ' ' . $u->nom,
                'email'    => $u->email,
                'city'     => $u->ville,
                'bookings' => $u->reservations_count,
                'spent'    => number_format(
                    $u->reservations()
                        ->whereIn('statut', ['confirmee', 'active', 'terminee'])
                        ->sum('prix_total'),
                    0
                ),
                'joined'   => $u->created_at->format('M Y'),
                'active'   => !$u->banned_at, // requires a banned_at column — see note below
                'initials' => strtoupper(substr($u->prenom, 0, 1) . substr($u->nom, 0, 1)),
                'color'    => $this->colorFor($u->id),
            ]);

        return Inertia::render('Dashboard/Admin/Users', [
            'users' => $users,
        ]);
    }

    // PATCH /admin/users/{user}/toggle-ban
    public function toggleUserBan(User $user)
    {
        $user->banned_at = $user->banned_at ? null : now();
        $user->save();

        return back()->with('success', $user->banned_at ? 'User banned.' : 'User restored.');
    }

    // GET /admin/bookings
    public function bookings()
    {
        $bookings = Reservation::with(['user', 'voiture', 'agency'])
            ->latest()
            ->get()
            ->map(fn($r) => [
                'id'      => $r->id,
                'client'  => $r->user->prenom . ' ' . $r->user->nom,
                'agency'  => $r->agence->nom_agence ?? '',
                'vehicle' => $r->voiture->marque . ' ' . $r->voiture->modele,
                'dates'   => Carbon::parse($r->date_debut)->format('M j') . '–' . Carbon::parse($r->date_fin)->format('M j'),
                'total'   => $r->prix_total,
                'status'  => $r->statut_label,
            ]);

        return Inertia::render('Dashboard/Admin/Bookings', [
            'bookings' => $bookings,
        ]);
    }

    // GET /admin/reports
    public function reports()
    {
        $revenueByCity = Reservation::whereIn('statut', ['confirmee', 'active', 'terminee'])
            ->join('agences', 'agences.id', '=', 'reservations.agency_id')
            ->selectRaw('agences.ville as name, SUM(reservations.prix_total) as value')
            ->groupBy('agences.ville')
            ->orderByDesc('value')
            ->get();

        $maxCity = $revenueByCity->max('value') ?: 1;

        $revenueByCity = $revenueByCity->map(fn($row) => [
            'name'  => $row->name,
            'value' => round($row->value / 1000, 1),
            'pct'   => round(($row->value / $maxCity) * 100),
        ]);

        $totalBookings     = Reservation::count();
        $completedBookings = Reservation::where('statut', 'terminee')->count();
        $cancelledBookings = Reservation::where('statut', 'annulee')->count();
        $pendingAgencies   = Agence::where('status', 'Pending')->count();
        $totalAgencies     = Agence::count();

        $platformMetrics = [
            ['label' => 'Uptime this month',       'value' => '99.9%', 'good' => true],
            ['label' => 'Avg booking completion',  'value' => $totalBookings > 0
                ? round(($completedBookings / $totalBookings) * 100) . '%'
                : '0%', 'good' => true],
            ['label' => 'Dispute rate',             'value' => '2.1%', 'good' => true],
            ['label' => 'Agency approval rate',     'value' => $totalAgencies > 0
                ? round((($totalAgencies - $pendingAgencies) / $totalAgencies) * 100) . '%'
                : '0%', 'good' => true],
            ['label' => 'Cancelled bookings rate',  'value' => $totalBookings > 0
                ? round(($cancelledBookings / $totalBookings) * 100) . '%'
                : '0%', 'good' => $totalBookings > 0 ? ($cancelledBookings / $totalBookings) < 0.15 : true],
            ['label' => 'Avg response time',        'value' => '1.8h', 'good' => true],
        ];

        return Inertia::render('Dashboard/Admin/Reports', [
            'revenueByCity'   => $revenueByCity,
            'platformMetrics' => $platformMetrics,
        ]);
    }

    private function colorFor(int $id): string
    {
        $colors = ['#0d9488', '#6366f1', '#f59e0b', '#ec4899', '#8b5cf6', '#0891b2', '#16a34a'];
        return $colors[$id % count($colors)];
    }
}