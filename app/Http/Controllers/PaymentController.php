<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function create()
    {
        return Inertia::render('Payment');
    }

    public function store(Request $request)
{
    $request->validate([
        'plan'         => ['required', 'string'],
        'billing'      => ['required', 'string'],
        'name'         => ['required', 'string'],
        'address'      => ['required', 'string'],
        'city'         => ['required', 'string'],
        'postal_code'  => ['required', 'string'],
        // Card validation (Mat-sauvegardihomch!)
        'card_number'  => ['required', 'string'],
        'expiry'       => ['required', 'string'],
        'cvv'          => ['required', 'string'],
    ]);

    $user = auth()->user();
    $agency = $user->agences; // Relation user -> agence

    // 1. Calcul dyal l-amount (Price Logic)
    $prices = ['starter' => 29, 'professional' => 79, 'enterprise' => 199];
    $basePrice = $prices[$request->plan] ?? 29;
    $finalAmount = $request->billing === 'yearly' ? $basePrice * 0.8 : $basePrice;

    // 2. Create Payment Record
    \App\Models\Payment::create([
        'agence_id'       => $agency->id,
        'user_id'         => $user->id,
        'plan'            => $request->plan,
        'billing_cycle'   => $request->billing,
        'amount'          => $finalAmount,
        'cardholder_name' => $request->name,
        'address'         => $request->address,
        'city'            => $request->city,
        'postal_code'     => $request->postal_code,
        'status'          => 'completed', // Dummy status for now
    ]);

    // 3. Update Agency Status
    $agency->update([
        'status' => 'active',
        'plan'   => $request->plan // optional: keep current plan in agency table for easy access
    ]);

    return redirect()->route('agency.dashboard')->with('success', 'Payment processed successfully!');
}
}