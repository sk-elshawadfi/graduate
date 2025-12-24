<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create()->each(function (User $user) {
            $user->syncRoles(['user']);

            Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => rand(100, 800), 'currency' => 'EGP']
            );
        });
    }
}
