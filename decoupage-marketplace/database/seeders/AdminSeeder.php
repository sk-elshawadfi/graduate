<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Operations Admin',
                'email' => 'admin@marketplace.com',
            ],
            [
                'name' => 'Moderator Admin',
                'email' => 'moderator@marketplace.com',
            ],
        ];

        foreach ($admins as $admin) {
            $user = User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            if (!$user->hasRole('super_admin')) {
                $user->syncRoles(['admin']);
            }

            Wallet::updateOrCreate(
                ['user_id' => $user->id],
                ['balance' => 500, 'currency' => 'EGP']
            );
        }
    }
}
