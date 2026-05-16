<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Mseh ga3 l-roles li kaynin 9bel bach t-bda mn jdid
    \DB::table('roles')->delete();

    \Spatie\Permission\Models\Role::create(['id' => 1, 'name' => 'admin', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::create(['id' => 2, 'name' => 'agence', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::create(['id' => 3, 'name' => 'client', 'guard_name' => 'web']);
}
}
