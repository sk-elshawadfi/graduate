<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\RecycleRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class FakeRecycleRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::role('user')->get();
        $admins = User::role(['admin', 'super_admin'])->get();

        if ($users->isEmpty()) {
            return;
        }

        RecycleRequest::factory(10)->make()->each(function (RecycleRequest $request) use ($users, $admins) {
            $user = $users->random();
            $request->user_id = $user->id;

            if ($admins->isNotEmpty() && rand(0, 1)) {
                $handler = $admins->random();
                $request->handled_by = $handler->id;
                $request->status = collect(['reviewing', 'approved', 'rejected', 'completed'])->random();
                $request->admin_price = rand(80, 400);
                $request->responded_at = now()->subDays(rand(1, 10));
                $request->feedback = fake()->sentence();
            }

            $request->save();

            if (in_array($request->status, ['approved', 'completed']) && $request->admin_price) {
                $wallet = $user->wallet()->firstOrCreate([], [
                    'balance' => 0,
                    'currency' => 'EGP',
                ]);

                $before = $wallet->balance;
                $after = $before + $request->admin_price;
                $wallet->update(['balance' => $after]);

                Transaction::create([
                    'wallet_id' => $wallet->id,
                    'subject_type' => RecycleRequest::class,
                    'subject_id' => $request->id,
                    'type' => 'credit',
                    'status' => 'completed',
                    'amount' => $request->admin_price,
                    'balance_before' => $before,
                    'balance_after' => $after,
                    'reference' => 'REC-' . $request->id,
                    'description' => 'Recycle request payout',
                ]);
            }

            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'recycle.submitted',
                'description' => 'Recycle request submitted',
                'subject_type' => RecycleRequest::class,
                'subject_id' => $request->id,
                'properties' => [
                    'status' => $request->status,
                    'request_type' => $request->request_type,
                ],
            ]);
        });
    }
}
