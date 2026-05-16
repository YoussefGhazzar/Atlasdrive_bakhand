<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agence_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Plan Info
        $table->string('plan');           // starter, professional, enterprise
        $table->string('billing_cycle');   // monthly, yearly
        $table->decimal('amount', 8, 2);   // e.g., 29.00, 79.00
        
        // Billing Address
        $table->string('cardholder_name');
        $table->string('address');
        $table->string('city');
        $table->string('postal_code');
        
        // Payment Status
        $table->string('status')->default('completed'); // pending, completed, failed
        $table->string('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
