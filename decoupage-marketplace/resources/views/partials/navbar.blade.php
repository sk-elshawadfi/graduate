<header class="sticky-top shadow-sm bg-white" id="top-nav">
    <div class="announcement-bar text-center py-1 bg-gradient">
        <span class="text-white small"><i class="fa-solid fa-leaf me-2"></i> Embrace sustainability – shop handmade decoupage & recycle with purpose.</span>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="/">
                <span class="brand-mark">DecoRecycle</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="/products">Shop</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('recycle*') ? 'active' : '' }}" href="/recycle">Recycle</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="/dashboard">Dashboard</a></li>
                </ul>
                <form class="d-flex align-items-center position-relative me-lg-3 nav-search">
                    <input class="form-control search-input" type="search" placeholder="Search crafts, artists..." aria-label="Search" />
                    <button class="btn btn-link text-muted search-btn" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-primary rounded-pill px-3" id="rtlToggle" aria-label="Toggle direction">
                        <i class="fa-solid fa-language me-1"></i> RTL
                    </button>
                    <a href="/cart" class="btn btn-icon position-relative">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span class="cart-dot" id="navCartCount">3</span>
                    </a>
                    <a href="/login" class="btn btn-primary rounded-pill px-4">Sign in</a>
                </div>
            </div>
        </div>
    </nav>
</header>
