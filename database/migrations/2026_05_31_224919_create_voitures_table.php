<?php
// php artisan make:migration create_voitures_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voitures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained('agences')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->string('marque');
            $table->string('modele');
            $table->smallInteger('annee');
            $table->string('immatriculation')->unique();
            $table->decimal('prix_par_jour', 8, 2);
            $table->integer('nb_places')->default(5);
            $table->string('transmission')->default('manuelle');  // manuelle | automatique
            $table->string('carburant')->default('essence');      // essence | diesel | electrique | hybride
            $table->string('couleur')->nullable();
            $table->string('image')->nullable();
            $table->boolean('disponible')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voitures');
    }
};