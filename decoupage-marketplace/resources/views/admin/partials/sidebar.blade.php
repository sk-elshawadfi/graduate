<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(auth()->user()->email)) }}?s=80&d=mp" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('profile.edit') }}" class="d-block">{{ auth()->user()->name }}</a>
                <span class="badge bg-success text-uppercase">{{ auth()->user()->roles->pluck('name')->implode(', ') }}</span>
            </div>
        </div>

        @php
            $nav = [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'fas fa-gauge'],
                ['label' => 'Users', 'route' => 'admin.users.index', 'icon' => 'fas fa-users'],
                ['label' => 'Categories', 'route' => 'admin.categories.index', 'icon' => 'fas fa-tags'],
                ['label' => 'Products', 'route' => 'admin.products.index', 'icon' => 'fas fa-boxes'],
                ['label' => 'Orders', 'route' => 'admin.orders.index', 'icon' => 'fas fa-shopping-bag'],
                ['label' => 'Recycle Requests', 'route' => 'admin.recycle-requests.index', 'icon' => 'fas fa-recycle'],
                ['label' => 'Wallets', 'route' => 'admin.wallets.index', 'icon' => 'fas fa-wallet'],
                ['label' => 'Transactions', 'route' => 'admin.transactions.index', 'icon' => 'fas fa-money-bill-transfer'],
                ['label' => 'Reviews', 'route' => 'admin.reviews.index', 'icon' => 'fas fa-star-half-alt'],
                ['label' => 'Activity Logs', 'route' => 'admin.activity-logs.index', 'icon' => 'fas fa-clipboard-list'],
            ];
        @endphp

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                @foreach($nav as $item)
                    <li class="nav-item">
                        <a href="{{ route($item['route']) }}" class="nav-link {{ request()->routeIs(str_replace('.index','.*',$item['route'])) ? 'active' : '' }}">
                            <i class="nav-icon {{ $item['icon'] }}"></i>
                            <p>{{ $item['label'] }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
