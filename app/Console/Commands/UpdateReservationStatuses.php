<?php

namespace App\Console\Commands;
use App\Models\Reservation;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateReservationStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    /**
     * The console command description.
     *
     * @var string
     */
    protected $signature = 'reservations:update-statuses';
    protected $description = 'Auto-flip confirmee→active on pickup day, active→terminee on return day';    

    /**
     * Execute the console command.
     */
    public function handle()
    {
              $today = Carbon::today();
 
        // confirmee → active (pickup day has arrived)
        $toActivate = Reservation::where('statut', 'confirmee')
            ->whereDate('date_debut', '<=', $today)
            ->get();
 
        foreach ($toActivate as $r) {
            $r->update(['statut' => 'active']);
            $r->voiture->update(['disponible' => false]);
        }
 
        // active → terminee (return day has passed)
        $toComplete = Reservation::where('statut', 'active')
            ->whereDate('date_fin', '<', $today)
            ->get();
 
        foreach ($toComplete as $r) {
            $r->update(['statut' => 'terminee']);
            $r->voiture->update(['disponible' => true]);
        }
 
        $this->info("Activated: {$toActivate->count()} | Completed: {$toComplete->count()}");
    }
    }

