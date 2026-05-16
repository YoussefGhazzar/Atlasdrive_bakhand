<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
        RolesAndPermissionsSeeder::class,
    ]);

      \App\Models\User::factory()->create([
        'nom' => 'Test', // Bdel 'name' b 'nom'
        'prenom' => 'User',
        'email' => 'test@example.com',
    ]);
    }
}
