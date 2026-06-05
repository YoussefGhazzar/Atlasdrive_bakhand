<?php
// php artisan make:migration create_reservations_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('voiture_id')->constrained('voitures')->onDelete('cascade');
            $table->foreignId('agency_id')->constrained('agences')->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin');
            // ✅ NO virtualAs — not supported in PostgreSQL
            // nb_jours is calculated in PHP (Reservation model or controller)
            $table->decimal('prix_total', 10, 2)->default(0);
            $table->string('statut')->default('en_attente');
            // statut values: en_attente | confirmee | active | terminee | annulee
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};