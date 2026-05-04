# Panduan Setup SI Qurban

Dokumen ini memandu Anda untuk menyiapkan *environment* pengembangan SI Qurban.

## Prasyarat Utama

- macOS dengan Apple Silicon didukung penuh (MacBook M1/M2/M3)
- PHP 8.2+ (Atau gunakan [Laravel Herd](https://herd.laravel.com/))
- Composer
- Node.js & npm (opsional untuk *development frontend*, jika menggunakan *pre-build* aset dapat dilewati)
- Database: **PostgreSQL** (via DBngin/Herd Pro) atau **MySQL 8** (via Docker)

---

## Opsi A: Setup Lokal (Laravel Herd + DBngin/PostgreSQL)

Pendekatan ini sangat direkomendasikan untuk pengguna macOS agar mendapat performa maksimal tanpa konfigurasi Docker yang berat.

1. **Jalankan Database PostgreSQL:**
   Pastikan Anda menyalakan PostgreSQL di port `5432` menggunakan DBngin, Herd Pro, atau Postgres.app. Buat database kosong bernama `siqurban`.

2. **Siapkan Konfigurasi Laravel:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   composer install
   ```

3. **Atur `.env` untuk PostgreSQL:**
   Pastikan pengaturan database Anda mengarah ke PostgreSQL lokal.
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=siqurban
   DB_USERNAME=postgres
   DB_PASSWORD=
   ```

4. **Jalankan Migrasi & Seeder:**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Web Server & WebSocket (Reverb):**
   Karena SI Qurban memiliki fitur notifikasi *real-time* dan *Live Feed*, Anda harus menyalakan server WebSocket:
   ```bash
   # Terminal 1 (Jika tidak memakai Herd otomatis)
   php artisan serve

   # Terminal 2 (Wajib jalan untuk Real-Time Notifikasi)
   php artisan reverb:start --port=8090
   ```

---

## Opsi B: Full Docker Compose (MySQL)

Bagi pengguna OS lain (Windows/Linux) atau yang ingin *environment* terisolasi sepenuhnya.

1. **Siapkan Environment Docker:**
   ```bash
   cp .env.docker.example .env.docker
   ```

2. **Jalankan Container:**
   ```bash
   docker compose up --build
   ```
   *Catatan: Container `siqurban-reverb` sudah diatur otomatis menyala di Docker Compose.*

3. **Akses Aplikasi:**
   - Web App: `http://localhost:8000`
   - phpMyAdmin: `http://localhost:8080`

---

## Akun Seeder (Akses Login)

Setelah menjalankan `php artisan migrate:fresh --seed`, Anda dapat mencoba masuk (login) menggunakan akun-akun berikut. Seluruh akun menggunakan **password baku:** `password`.

### 🛡️ Role Admin (Dashboard & Audit Logs)
- `Super Admin`
- `Admin SI Qurban`
- `Budi Santoso`
- `Siti Aminah`

### 🧑‍💼 Role Panitia (Scan & Distribusi)
- `Ahmad Fauzi`
- `Siti Rahma`
- `Muhammad Rizky`
- `Nur Aisyah`
- `Bagas Santoso`
- `Lestari Indah`
- `Wahyu Hidayat`
- `Dina Mariana`
- `Eko Prasetyo`
- `Rini Wulandari`

---

## Fitur Pemantauan Khusus

Sistem ini dilengkapi dua fitur pemantauan lanjutan untuk memfasilitasi peran Admin:

1. **Notifikasi Real-Time (Notification Bell):**
   Lonceng notifikasi di sudut kanan atas layar Admin dan Panitia menyala jika ada aksi *scan* kupon yang sukses atau jika ada perubahan sistem (*Audit Log*). Pastikan *Reverb* berjalan (Port 8090) agar fitur ini aktif.

2. **Laravel Pulse (Server Monitoring):**
   Akses `http://localhost:8000/admin/pulse` (Khusus Admin) untuk memantau beban CPU server, antrean *job*, performa memori, hingga metrik aplikasi secara instan.
