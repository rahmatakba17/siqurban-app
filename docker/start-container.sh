#!/usr/bin/env bash
# ═══════════════════════════════════════════════════════════════
# SI Qurban — Docker Container Startup Script
# Berjalan pertama kali saat container app dimulai
# ═══════════════════════════════════════════════════════════════
set -euo pipefail

CYAN='\033[0;36m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

log()  { echo -e "${CYAN}[SI Qurban]${NC} $1"; }
ok()   { echo -e "${GREEN}[SI Qurban] ✅ $1${NC}"; }
warn() { echo -e "${YELLOW}[SI Qurban] ⚠️  $1${NC}"; }

cd /var/www/html

echo ""
echo -e "${CYAN}═══════════════════════════════════════════════════${NC}"
echo -e "${CYAN}  🐫 SI Qurban — Starting Docker Container${NC}"
echo -e "${CYAN}═══════════════════════════════════════════════════${NC}"
echo ""

# ── 1. Setup .env ─────────────────────────────────────────────
if [ ! -f .env ]; then
    if [ -f .env.docker ]; then
        cp .env.docker .env
        log ".env dibuat dari .env.docker"
    else
        warn ".env.docker tidak ada! Gunakan .env.docker.example"
        cp .env.docker.example .env 2>/dev/null || { echo "${RED}ERROR: File .env tidak ditemukan!${NC}"; exit 1; }
    fi
fi

# ── 2. Generate APP_KEY jika kosong ──────────────────────────
if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    log "Membuat APP_KEY baru..."
    php artisan key:generate --force --quiet
    ok "APP_KEY berhasil dibuat"
fi

# ── 3. Tunggu MySQL siap (retry 30x dengan jeda 2 detik) ─────
log "Menunggu koneksi database..."
MAX_TRIES=30
TRIES=0
until php artisan db:show --quiet 2>/dev/null || [ $TRIES -ge $MAX_TRIES ]; do
    TRIES=$((TRIES + 1))
    log "Database belum siap... (${TRIES}/${MAX_TRIES})"
    sleep 2
done

if [ $TRIES -ge $MAX_TRIES ]; then
    warn "Database tidak merespons setelah ${MAX_TRIES} percobaan. Tetap lanjutkan..."
fi

# ── 4. Run Migrations ─────────────────────────────────────────
log "Menjalankan migrations..."
php artisan migrate --force --quiet
ok "Migrations selesai"

# ── 5. Run Pulse Migrations (jika belum ada) ─────────────────
log "Memeriksa tabel Pulse..."
php artisan vendor:publish --tag=pulse-migrations --quiet 2>/dev/null || true
php artisan migrate --force --quiet
ok "Pulse tables siap"

# ── 6. Jalankan Seeder (hanya jika DB masih kosong) ──────────
COUPON_COUNT=$(php artisan tinker --no-interaction --execute="echo \App\Models\User::count();" 2>/dev/null | tail -1 || echo "0")
if [ "$COUPON_COUNT" = "0" ] || [ -z "$COUPON_COUNT" ]; then
    log "Database kosong — menjalankan seeder demo..."
    php artisan db:seed --force --quiet
    ok "Demo data berhasil dimuat"
else
    log "Database sudah berisi data — skip seeder"
fi

# ── 7. Storage link ───────────────────────────────────────────
if [ ! -L public/storage ]; then
    php artisan storage:link --quiet 2>/dev/null || true
    ok "Storage link dibuat"
fi

# ── 8. Optimasi Laravel ───────────────────────────────────────
log "Mengoptimasi aplikasi..."
php artisan config:cache  --quiet 2>/dev/null || true
php artisan route:cache   --quiet 2>/dev/null || true
php artisan view:cache    --quiet 2>/dev/null || true
php artisan event:cache   --quiet 2>/dev/null || true
ok "Optimasi selesai"

# ── 9. Fix permissions ────────────────────────────────────────
chown -R www:www /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# ── 10. Info startup ─────────────────────────────────────────
echo ""
echo -e "${GREEN}═══════════════════════════════════════════════════${NC}"
ok "Aplikasi siap digunakan!"
echo -e "${GREEN}  🌐 App:        http://localhost:8000${NC}"
echo -e "${GREEN}  🔭 Pulse:      http://localhost:8000/admin/pulse${NC}"
echo -e "${GREEN}  🗄️  phpMyAdmin: http://localhost:8080${NC}"
echo -e "${GREEN}  📡 Reverb WS:  ws://localhost:8090${NC}"
echo -e "${GREEN}  👤 Admin:      admin@siqurban.local${NC}"
echo -e "${GREEN}  🔑 Password:   password${NC}"
echo -e "${GREEN}═══════════════════════════════════════════════════${NC}"
echo ""

# ── 11. Jalankan Supervisor (manages nginx + php-fpm + queue + pulse) ──
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
