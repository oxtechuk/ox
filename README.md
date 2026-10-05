# OX Tech Enterprise Cloud Solutions & Software Engineering

Enterprise-grade software engineering platform and digital storefront built with Laravel 13, PHP 8.4, and modern MySQL architecture.

---

## 1. System Requirements

- **PHP**: `^8.4` with extensions:
  - `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `hash`, `intl`, `json`, `mbstring`, `openssl`, `pcre`, `pdo_mysql`, `session`, `tokenizer`, `xml`, `zip`
- **Database**: MySQL `>= 8.0` or MariaDB `>= 10.5`
- **Composer**: `^2.2`
- **Node.js**: `>= 20.x` & NPM `>= 10.x`
- **Web Server**: Nginx or Apache (Document Root **must** point to `/public`)

---

## 2. Local & Server Installation

```bash
# 1. Clone repository
git clone <repo_url> /var/www/ox
cd /var/www/ox

# 2. Install PHP dependencies
composer install --no-dev --optimize-autoloader

# 3. Setup environment configuration
cp .env.example .env
php artisan key:generate

# 4. Configure Database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ox_tech_db
DB_USERNAME=ox_user
DB_PASSWORD=secret_password

# 5. Run Database Migrations
php artisan migrate --force

# 6. Create Public Storage Symlink
php artisan storage:link

# 7. Install Frontend Assets & Build
npm ci
npm run build
```

---

## 3. Production Deployment Commands

Run these steps during zero-downtime deployment pipelines:

```bash
# Pull latest code
git pull origin main

# Update dependencies & optimize autoloader
composer install --no-dev --optimize-autoloader --no-interaction

# Run safe database migrations
php artisan migrate --force

# Cache configuration, routes, and views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build optimized production assets
npm ci
npm run build

# Restart background queue workers
php artisan queue:restart
```

---

## 4. Background Workers & Queue Management

Production emails (consultation alerts, order fulfillments, invoice transmissions) use Laravel Queues to guarantee instantaneous HTTP responses.

### Supervisor Configuration (`/etc/supervisor/conf.d/ox-worker.conf`)

```ini
[program:ox-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/ox/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/ox/storage/logs/worker.log
stopwaitsecs=3600
```

---

## 5. Cron & Scheduler

Add the Laravel scheduler cron entry to the web server:

```cron
* * * * * cd /var/www/ox && php artisan schedule:run >> /dev/null 2>&1
```

---

## 6. Security & Hardening Features

1. **HMAC-SHA256 Signature Verification**: All PaySky payment callbacks and server-to-server webhooks verify cryptographic signatures prior to order fulfillment.
2. **Role-Based Admin Protection**: `AdminAuth` middleware strictly validates admin privileges (`super_admin`, `admin`, `editor`) and active account status, rejecting unauthorized users with `403 Forbidden`.
3. **HTTP Security Headers**: Auto-injected headers including `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `Referrer-Policy: strict-origin-when-cross-origin`, and `Permissions-Policy`.
4. **Rate Limiting**: Automated IP-based throttle buckets protecting `/consultation/store`, `/checkout/initiate`, `/admin/login`, `/account/login`, and `/downloads/{token}`.
5. **Branded Custom Error Views**: Production-ready, responsive, accessible error pages in `resources/views/errors/` for `404`, `403`, `419`, `429`, `500`, and `503`.

---

## 7. Automated Testing

Run the comprehensive PHPUnit test suite:

```bash
php artisan test
```

---

## 8. Troubleshooting & Maintenance

| Issue | Cause | Resolution |
|---|---|---|
| `419 Page Expired` | Expired CSRF token or session timeout | Ensure forms include `@csrf` and sessions are stored in database/redis. |
| `Storage permission denied` | Web server user lacks write permissions | `chown -R www-data:www-data storage bootstrap/cache` |
| `Vite manifest not found` | Assets not built | Run `npm run build` |
| `Queue jobs failing` | Mail credentials / API down | Check `failed_jobs` table and `php artisan queue:retry all` |
