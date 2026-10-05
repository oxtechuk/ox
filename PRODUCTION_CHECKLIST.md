# Production Deployment Checklist for OX Tech

---

### 1. Application & Environment
- [x] `APP_ENV=production` configured in `.env`
- [x] `APP_DEBUG=false` verified
- [x] `APP_URL` configured with valid production HTTPS domain (e.g. `https://ox-tech.sa`)
- [x] `APP_KEY` securely generated and backed up
- [x] Web server document root pointing strictly to `/public` (never project root)

---

### 2. Security Hardening
- [x] HTTPS enforced with valid TLS certificate (Let's Encrypt / Cloudflare)
- [x] Secure session cookies enabled (`SESSION_SECURE_COOKIE=true`, `SESSION_HTTP_ONLY=true`, `SESSION_SAME_SITE=lax`)
- [x] PaySky HMAC-SHA256 signature verification active on callbacks and webhooks
- [x] Role-based admin access control verified on all `/admin/*` routes
- [x] Rate limiting active on login endpoints, lead consultation form, and checkout initiation
- [x] Security headers injected (`X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Referrer-Policy`)
- [x] CSRF protection enforced across all web forms
- [x] File uploads strictly validated for MIME type, extension, and size
- [x] Sensitive environment credentials removed from version control (`.env` in `.gitignore`)

---

### 3. Performance & Optimization
- [x] Configuration cache verified: `php artisan config:cache`
- [x] Route cache verified: `php artisan route:cache`
- [x] View cache verified: `php artisan view:cache`
- [x] Database indexes applied for `projects`, `digital_products`, `orders`, and `landing_pages`
- [x] Production asset bundle compiled: `npm run build`
- [x] OPcache enabled in production `php.ini` (`opcache.enable=1`, `opcache.memory_consumption=256`)
- [x] Asynchronous queuing configured for transaction emails (`QUEUE_CONNECTION=database` or `redis`)

---

### 4. SEO & Error Handling
- [x] Custom branded error views deployed: `404.blade.php`, `403.blade.php`, `419.blade.php`, `429.blade.php`, `500.blade.php`, `503.blade.php`
- [x] Dynamic XML Sitemap (`/sitemap.xml`) indexing portfolio, digital products, and multilingual alternates
- [x] Dynamic `robots.txt` (`/robots.txt`) with sitemap reference and sensitive path disallows
- [x] Schema.org JSON-LD structured data implemented for Organization, WebSite, and SoftwareApplication
- [x] OpenGraph and Twitter card social meta tags active

---

### 5. Infrastructure & Operations
- [x] Background worker active via Supervisor (`php artisan queue:work`)
- [x] Cron scheduler active (`* * * * * php artisan schedule:run`)
- [x] Storage symlink created (`php artisan storage:link`)
- [x] Automated database backup scheduled and retention configured
- [x] Log rotation configured (`LOG_CHANNEL=daily` or stack)
- [x] Production test suite executed and passing 100%
