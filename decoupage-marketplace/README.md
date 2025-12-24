# Decoupage & Recycling Marketplace

A full-stack Laravel 10 marketplace that showcases handmade decoupage art, upcycled decor, and recycling services. The project ships with Docker, Breeze authentication, spatie/laravel-permission roles, a handcrafted AdminLTE 3 backend, wallet + transaction tracking, and a Shopify-inspired Blade frontend.

## Tech stack
- Laravel 10 (PHP 8.2) + Breeze (Blade)
- MySQL 8, phpMyAdmin
- Docker & Docker Compose
- AdminLTE 3 dashboard with Bootstrap 5 accents
- spatie/laravel-permission for role-based access
- Bootstrap 5 storefront + Font Awesome + Google Font Cairo

## Getting started

### 1. Environment
```bash
cp .env.example .env   # already pre-configured for Docker
composer install
npm install && npm run build
php artisan key:generate
```

### 2. Docker services
```bash
docker compose up -d --build
```
Services:
- App (PHP 8.2) → http://localhost:8000
- MySQL 8 → localhost:3306 (user: `marketplace` / pass: `marketplace` / db: `decoupage_marketplace`)
- phpMyAdmin → http://localhost:8081

### 3. Database
```bash
php artisan migrate --seed
php artisan storage:link
```
Seeds include roles, users (20), admins, a default super admin, 10 categories, 50 products, fake orders, wallets, transactions, and recycle requests.

Default super admin:
```
Email: admin@admin.com
Password: password
```

### 4. Running locally
- Laravel app: `php artisan serve` (or via Docker service)
- Asset building: `npm run dev` (watch) or `npm run build`

## Admin panel
The custom AdminLTE 3 control center lives at `/admin` (auth + verified + role-protected). Highlights:

- Dashboard with key stats (users, orders, revenue, recycle queue, wallet totals) plus latest orders/transactions.
- **Users**: CRUD, ban/unban, wallet status, role assignment (only super admins can promote admins).
- **Catalog**: Categories + products with full CRUD, galleries, featured toggles.
- **Orders**: Status + payment management, mock wallet capture, item breakdown.
- **Recycle requests**: Review queue, payouts, file uploads, wallet credits, staff feedback.
- **Wallets & transactions**: Manual adjustments, mock credits/debits, withdraw tracking.
- **Reviews**: Moderation queue with visibility toggles.
- **Activity logs**: Audit trail of every admin action.

## Frontend features
- Shopify-inspired homepage (hero, featured grid, categories, recycle highlights, reviews).
- Product listing with filters/search/pagination and a detail page with image gallery + reviews.
- Session-based cart with AJAX add/update/remove and live totals.
- Mock checkout flow (COD or wallet) with confirmation page.
- Recycle request form (image upload + AJAX feedback) and status tracking.
- User dashboard showing orders, wallets, recycle requests, and profile settings.

## Testing / linting
Run the default Laravel test suite:
```bash
php artisan test
```

## Docker commands quick reference
```bash
docker compose up -d        # start services
docker compose down         # stop all containers
docker compose logs -f app  # tail PHP logs
```

## Notes
- CSRF + form request validation on all user inputs
- Activity logging captures major events (orders, recycle requests, transactions)
- Ready for real payment gateway integration by swapping the mock wallet/COD logic
