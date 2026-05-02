#!/usr/bin/env bash
set -e

cd /var/www/html

echo "[SI Qurban] ═══════════════════════════════════"
echo "[SI Qurban] 🚀 Starting with Octane + FrankenPHP"
echo "[SI Qurban] ═══════════════════════════════════"

# ── 1. Setup .env ─────────────────────────────────────────────
if [ ! -f .env ]; then
    cp .env.docker .env
    echo "[SI Qurban] .env dibuat dari .env.docker"
fi

# ── 2. Composer install ───────────────────────────────────────
if [ ! -f vendor/autoload.php ]; then
    echo "[SI Qurban] Menginstall Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# ── 3. App key ───────────────────────────────────────────────
if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

# ── 4. Storage link ──────────────────────────────────────────
[ ! -L public/storage ] && php artisan storage:link --quiet || true

# ── 5. Migrate & seed ────────────────────────────────────────
echo "[SI Qurban] Running migrations..."
php artisan migrate --force
php artisan db:seed --force

# ── 6. Pulse migrations ──────────────────────────────────────
echo "[SI Qurban] Running Pulse migrations..."
php artisan vendor:publish --tag=pulse-migrations --force 2>/dev/null || true
php artisan migrate --force

# ── 7. Optimize ──────────────────────────────────────────────
php artisan config:cache  --quiet || true
php artisan route:cache   --quiet || true
php artisan view:cache    --quiet || true
php artisan event:cache   --quiet || true

echo "[SI Qurban] ✅ App: http://localhost:8000"
echo "[SI Qurban] 🔭 Pulse: http://localhost:8000/admin/pulse"
echo "[SI Qurban] 📊 phpMyAdmin: http://localhost:8080"
echo "[SI Qurban] 📡 Reverb: ws://localhost:8090"
echo "[SI Qurban] 👤 admin@siqurban.local / password"

# ── 8. Start Octane ──────────────────────────────────────────
exec php artisan octane:start \
    --server=frankenphp \
    --host=0.0.0.0 \
    --port=8000 \
    --workers=4 \
    --task-workers=2 \
    --max-requests=250
