<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\RecycleRequest;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Policies\ActivityLogPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RecycleRequestPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserPolicy;
use App\Policies\WalletPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Product::class => ProductPolicy::class,
        Order::class => OrderPolicy::class,
        RecycleRequest::class => RecycleRequestPolicy::class,
        Wallet::class => WalletPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Review::class => ReviewPolicy::class,
        ActivityLog::class => ActivityLogPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
