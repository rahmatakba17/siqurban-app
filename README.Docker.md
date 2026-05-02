# 🐫 SI Qurban — Panduan Docker Desktop

## Deskripsi

SI Qurban adalah aplikasi web distribusi kupon kurban digital berbasis **Laravel 11**.  
Panduan ini menjelaskan cara menjalankan aplikasi di **Windows, macOS, dan Linux** menggunakan Docker Desktop — tanpa perlu menginstall PHP, MySQL, atau Node.js secara langsung.

---

## 🖥️ Persyaratan Sistem

| OS | Persyaratan |
|---|---|
| **Windows 10/11** | Docker Desktop ≥ 4.25, WSL2 aktif |
| **macOS** | Docker Desktop ≥ 4.25 (Intel atau Apple Silicon) |
| **Linux** | Docker Engine ≥ 24 + Docker Compose Plugin v2 |

> **Download Docker Desktop**: https://www.docker.com/products/docker-desktop/

---

## 🚀 Cara Pertama Kali (Setup)

### Windows (Command Prompt / PowerShell)

```cmd
REM 1. Clone atau extract proyek
cd C:\Projects\KUPON-QURBAN

REM 2. Salin file environment
copy .env.docker.example .env.docker

REM 3. Build dan jalankan (butuh beberapa menit pertama kali)
docker compose up --build -d

REM 4. Buka browser
start http://localhost:8000
```

### macOS / Linux (Terminal)

```bash
# 1. Masuk ke folder proyek
cd ~/Projects/KUPON-QURBAN

# 2. Salin file environment
cp .env.docker.example .env.docker

# 3. Setup otomatis (gunakan Makefile)
make setup

# Atau manual:
docker compose up --build -d
```

---

## 🌐 Akses Layanan

Setelah container berjalan, buka browser dan akses:

| Layanan | URL | Keterangan |
|---|---|---|
| **Aplikasi** | http://localhost:8000 | Halaman utama SI Qurban |
| **Pulse Monitor** | http://localhost:8000/admin/pulse | Monitoring kesehatan aplikasi |
| **phpMyAdmin** | http://localhost:8080 | Manajemen database via browser |
| **Reverb WS** | ws://localhost:8090 | WebSocket real-time (internal) |

### Akun Login Default

| Role | Email | Password |
|---|---|---|
| Admin | admin@siqurban.local | password |
| Panitia 1 | panitia1@siqurban.local | password |
| Panitia 2 | panitia2@siqurban.local | password |

---

## 📋 Perintah Sehari-hari

### Menggunakan Makefile (macOS/Linux)

```bash
make up          # Jalankan aplikasi
make down        # Matikan aplikasi
make restart     # Restart semua service
make logs        # Lihat log real-time
make status      # Cek status container
make shell       # Masuk ke terminal container
make artisan CMD="route:list"  # Jalankan artisan command apapun
make fresh-db    # Reset database (⚠️ hapus semua data)
make help        # Lihat semua perintah yang tersedia
```

### Menggunakan Docker Compose Langsung (Windows/macOS/Linux)

```bash
# Jalankan aplikasi
docker compose up -d

# Matikan aplikasi
docker compose down

# Lihat log
docker compose logs -f

# Masuk ke terminal container app
docker compose exec app bash

# Jalankan artisan command
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
docker compose exec app php artisan tinker

# Reset database
docker compose exec app php artisan migrate:fresh --seed --force
```

---

## 🔧 Konfigurasi Port (Jika Ada Konflik)

Jika ada aplikasi lain yang sudah memakai port yang sama, edit file `.env.docker`:

```env
APP_PORT=8001      # Ganti 8000 → 8001
PMA_PORT=8081      # Ganti 8080 → 8081
REVERB_PORT=8091   # Ganti 8090 → 8091
MYSQL_PORT=3307    # Ganti 3306 → 3307
```

Lalu restart:

```bash
docker compose down && docker compose up -d
```

---

## 🏗️ Arsitektur Docker

```
┌─────────────────────────────────────────────────┐
│               Docker Desktop                    │
│                                                 │
│  ┌─────────────────┐    ┌──────────────────┐   │
│  │  siqurban-app   │    │ siqurban-reverb  │   │
│  │  (port 80→8000) │    │ (port 8090)      │   │
│  │                 │    │  WebSocket WS    │   │
│  │  ┌───────────┐  │    └──────────────────┘   │
│  │  │  Nginx    │  │                            │
│  │  ├───────────┤  │    ┌──────────────────┐   │
│  │  │ PHP-FPM   │  │    │ siqurban-mysql   │   │
│  │  ├───────────┤  │───▶│  (port 3306)     │   │
│  │  │  Queue    │  │    │  MySQL 8.4       │   │
│  │  ├───────────┤  │    └──────────────────┘   │
│  │  │  Pulse    │  │                            │
│  │  └───────────┘  │    ┌──────────────────┐   │
│  └─────────────────┘    │ siqurban-pma     │   │
│                          │  (port 8080)     │   │
│                          │  phpMyAdmin      │   │
│                          └──────────────────┘   │
└─────────────────────────────────────────────────┘
```

---

## 🔭 Laravel Pulse (Monitoring)

Pulse menampilkan kesehatan aplikasi secara real-time:

1. Buka http://localhost:8000/admin/pulse  
2. Login sebagai Admin  
3. Pantau: CPU, request lambat, error, user aktif

---

## 📡 Real-Time dengan Reverb

Ketika panitia scan kupon → dashboard admin **otomatis update** tanpa refresh:

```
Panitia scan → ScanController → broadcast event → Reverb WS → Echo.js → Dashboard update
```

Untuk tes: Buka dashboard admin dan halaman scan di dua tab berbeda.

---

## ⚠️ Troubleshooting

### Port sudah dipakai (Windows/macOS)

```bash
# Cek port yang aktif
docker compose ps

# Ganti port di .env.docker lalu restart
docker compose down && docker compose up -d
```

### Container tidak mau start

```bash
# Lihat log error
docker compose logs app

# Hapus volume dan mulai ulang
docker compose down -v
docker compose up --build -d
```

### Database tidak terhubung

```bash
# Pastikan MySQL sudah healthy
docker compose ps mysql

# Test koneksi manual
docker compose exec app php artisan db:show
```

### Reset Total (Mulai dari Awal)

```bash
# ⚠️ HAPUS SEMUA DATA
docker compose down -v
docker compose up --build -d
```

### Windows: Error WSL2

1. Buka PowerShell sebagai Administrator
2. Jalankan: `wsl --update`
3. Restart Docker Desktop

---

## 📦 Fitur yang Sudah Aktif di Docker

| Fitur | Status | Keterangan |
|---|---|---|
| **Laravel 11** | ✅ Aktif | Nginx + PHP-FPM via Supervisor |
| **MySQL 8.4** | ✅ Aktif | Persistent volume |
| **phpMyAdmin** | ✅ Aktif | http://localhost:8080 |
| **Reverb WS** | ✅ Aktif | Service terpisah port 8090 |
| **Queue Worker** | ✅ Aktif | Dijalankan via Supervisor |
| **Pulse Monitor** | ✅ Aktif | http://localhost:8000/admin/pulse |
| **Livewire** | ✅ Aktif | Auto-poll + real-time update |
| **Sanctum API** | ✅ Aktif | 12 endpoint REST API |
| **TailwindCSS** | ✅ Built | Di-build saat docker build |
| **QR Code SVG** | ✅ Aktif | chillerlan/php-qrcode |
| **Export Excel** | ✅ Aktif | phpoffice/phpspreadsheet |
