<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'renter', 'guard_name' => 'web']);
        Role::create(['name' => 'rentor', 'guard_name' => 'web']);
    }
}