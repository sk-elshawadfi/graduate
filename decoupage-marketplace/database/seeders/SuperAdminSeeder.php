<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_banned' => false,
            ]
        );

        $user->syncRoles(['super_admin']);

        Wallet::updateOrCreate(
            ['user_id' => $user->id],
            ['balance' => 1000, 'currency' => 'EGP']
        );
    }
}
