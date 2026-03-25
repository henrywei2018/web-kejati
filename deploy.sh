#!/bin/bash
# ─────────────────────────────────────────────────────────────────
# Production deployment script for web-kejati (low-resource server)
#
# Run this script after pulling new code to production:
#   bash deploy.sh
# ─────────────────────────────────────────────────────────────────

set -e

echo ""
echo "==> [1/8] Installing PHP dependencies (production mode)..."
composer install --no-dev --optimize-autoloader --no-interaction

echo ""
echo "==> [2/8] Installing & building frontend assets..."
npm ci --prefer-offline
npm run build

echo ""
echo "==> [3/8] Running database migrations..."
php artisan migrate --force

echo ""
echo "==> [4/8] Clearing all stale caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

echo ""
echo "==> [5/8] Warming production caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan icons:cache 2>/dev/null || true

echo ""
echo "==> [6/8] Linking storage..."
# storage:link is critical — without it all uploaded files return 404.
# Exits with "already exists" if already linked, which is fine.
php artisan storage:link || echo "  ⚠ storage:link already exists or failed — verify public/storage symlink manually"

echo ""
echo "==> [7/8] Setting file permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

echo ""
echo "==> [8/8] Done!"
echo ""
echo "  Server optimisation checklist:"
echo "  ✓ Autoloader optimised (--optimize-autoloader)"
echo "  ✓ Config/Route/View cached"
echo "  ✓ Database migrations applied"
echo "  ✓ Page caches cleared (fresh start)"
echo ""
echo "  Recommended .env settings for low-resource server:"
echo "  APP_ENV=production"
echo "  APP_DEBUG=false"
echo "  CACHE_DRIVER=database   (or redis if available)"
echo "  SESSION_DRIVER=database (or redis if available)"
echo "  QUEUE_CONNECTION=database"
echo ""
echo "  If you have Redis available, also run:"
echo "  php artisan queue:work --daemon --sleep=3 --tries=3"
echo ""
