<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create the 'rentor' role if it doesn't exist
        if (!Role::where('name', 'rentor')->exists()) {
            Role::create(['name' => 'rentor']);
        }
        Role::create(['name' => 'renter', 'guard_name' => 'web']);
    }
}