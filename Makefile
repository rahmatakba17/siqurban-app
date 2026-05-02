# ═══════════════════════════════════════════════════════════════
# SI Qurban — Makefile
# Shortcut perintah Docker untuk semua OS
#
# CARA PAKAI:
#   make setup    → Pertama kali, setup semua
#   make up       → Jalankan aplikasi
#   make down     → Matikan aplikasi
#   make logs     → Lihat log
# ═══════════════════════════════════════════════════════════════

.PHONY: help setup up down restart build logs shell db-shell artisan tinker \
        migrate seed fresh-db test clean reset status

# Default target
.DEFAULT_GOAL := help

# Warna terminal
CYAN  := \033[0;36m
GREEN := \033[0;32m
RESET := \033[0m

## ── HELP ─────────────────────────────────────────────────────
help: ## Tampilkan daftar perintah yang tersedia
	@echo ""
	@echo "$(CYAN)🐫 SI Qurban — Docker Commands$(RESET)"
	@echo "$(CYAN)════════════════════════════════════════$(RESET)"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | \
		awk 'BEGIN {FS = ":.*?## "}; {printf "  $(GREEN)make %-16s$(RESET) %s\n", $$1, $$2}'
	@echo ""

## ── SETUP (Pertama Kali) ─────────────────────────────────────
setup: ## 🚀 Setup pertama kali (copy .env, build, start)
	@echo "$(CYAN)[1/3] Menyiapkan file environment...$(RESET)"
	@test -f .env.docker || cp .env.docker.example .env.docker
	@echo "$(CYAN)[2/3] Membangun Docker image...$(RESET)"
	@docker compose build --no-cache
	@echo "$(CYAN)[3/3] Menjalankan aplikasi...$(RESET)"
	@docker compose up -d
	@echo ""
	@echo "$(GREEN)✅ Setup selesai!$(RESET)"
	@echo "$(GREEN)   🌐 Buka: http://localhost:8000$(RESET)"
	@echo "$(GREEN)   🗄️  phpMyAdmin: http://localhost:8080$(RESET)"
	@echo "$(GREEN)   👤 admin@siqurban.local / password$(RESET)"

## ── BASIC OPERATIONS ─────────────────────────────────────────
up: ## ▶️  Jalankan semua service (background)
	docker compose up -d
	@echo "$(GREEN)✅ Aplikasi berjalan di http://localhost:8000$(RESET)"

down: ## ⏹️  Matikan semua service
	docker compose down
	@echo "$(GREEN)✅ Semua service dihentikan$(RESET)"

restart: ## 🔄 Restart semua service
	docker compose restart
	@echo "$(GREEN)✅ Semua service di-restart$(RESET)"

build: ## 🔨 Build ulang image (setelah perubahan kode)
	docker compose build --no-cache
	@echo "$(GREEN)✅ Build selesai$(RESET)"

rebuild: ## 🔨 Build ulang + restart
	docker compose down
	docker compose build --no-cache
	docker compose up -d

status: ## 📊 Lihat status semua container
	docker compose ps

## ── LOGS ─────────────────────────────────────────────────────
logs: ## 📋 Lihat semua log (Ctrl+C untuk keluar)
	docker compose logs -f

logs-app: ## 📋 Log aplikasi saja
	docker compose logs -f app

logs-reverb: ## 📋 Log Reverb WebSocket
	docker compose logs -f reverb

logs-db: ## 📋 Log MySQL
	docker compose logs -f mysql

## ── AKSES CONTAINER ──────────────────────────────────────────
shell: ## 🐚 Masuk ke shell container app (bash)
	docker compose exec app bash

shell-root: ## 🐚 Masuk sebagai root
	docker compose exec -u root app bash

db-shell: ## 🗄️  Masuk ke MySQL shell
	docker compose exec mysql mysql -u siqurban -psecret_siqurban_2025 siqurban

## ── LARAVEL ARTISAN ──────────────────────────────────────────
artisan: ## ⚙️  Jalankan artisan command (make artisan CMD="migrate")
	docker compose exec app php artisan $(CMD)

tinker: ## 🧪 Buka Laravel Tinker (REPL)
	docker compose exec app php artisan tinker

migrate: ## 🗄️  Jalankan migrations
	docker compose exec app php artisan migrate --force

seed: ## 🌱 Jalankan seeders (data demo)
	docker compose exec app php artisan db:seed --force

fresh-db: ## ⚠️  Reset database + seed ulang (HAPUS SEMUA DATA!)
	@echo "$(CYAN)⚠️  Ini akan MENGHAPUS semua data. Yakin? (Ctrl+C untuk batal)$(RESET)"
	@sleep 3
	docker compose exec app php artisan migrate:fresh --seed --force

cache-clear: ## 🧹 Bersihkan semua cache
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan route:clear
	docker compose exec app php artisan view:clear
	docker compose exec app php artisan cache:clear

optimize: ## ⚡ Optimasi cache Laravel
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache
	docker compose exec app php artisan event:cache

## ── DEVELOPMENT ──────────────────────────────────────────────
npm-install: ## 📦 Install npm packages (di host)
	npm install

npm-build: ## 🎨 Build frontend assets (di host)
	npm run build

npm-dev: ## 🎨 Watch frontend assets (dev mode)
	npm run dev

composer-install: ## 📦 Install Composer packages dalam container
	docker compose exec app composer install

composer-update: ## 📦 Update Composer packages dalam container
	docker compose exec app composer update

## ── MAINTENANCE ──────────────────────────────────────────────
clean: ## 🧹 Hapus container dan volume sementara (data MySQL tetap aman)
	docker compose down --remove-orphans

reset: ## 💥 HAPUS SEMUA (container + volumes + data MySQL!)
	@echo "$(CYAN)⚠️  Ini akan MENGHAPUS SEMUA DATA termasuk database!$(RESET)"
	@echo "$(CYAN)Tekan Ctrl+C untuk batal atau tunggu 5 detik...$(RESET)"
	@sleep 5
	docker compose down -v --remove-orphans
	docker volume rm siqurban-mysql-data siqurban-vendor siqurban-build siqurban-storage 2>/dev/null || true
	@echo "$(GREEN)✅ Reset selesai. Jalankan 'make setup' untuk mulai dari awal.$(RESET)"

pulse: ## 🔭 Akses Pulse monitoring (browser)
	@echo "$(GREEN)Buka: http://localhost:8000/admin/pulse$(RESET)"
	@open http://localhost:8000/admin/pulse 2>/dev/null || \
	 xdg-open http://localhost:8000/admin/pulse 2>/dev/null || \
	 start http://localhost:8000/admin/pulse 2>/dev/null || true

open: ## 🌐 Buka aplikasi di browser
	@open http://localhost:8000 2>/dev/null || \
	 xdg-open http://localhost:8000 2>/dev/null || \
	 start http://localhost:8000 2>/dev/null || true
