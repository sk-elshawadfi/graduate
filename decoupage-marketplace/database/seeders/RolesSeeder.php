<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(['user', 'admin', 'super_admin'])->each(function (string $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        });
    }
}
