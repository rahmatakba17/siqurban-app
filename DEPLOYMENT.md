# Deployment Ringkas SI Qurban

## Opsi Lokal untuk MacBook M2

### Laravel Herd + Docker Desktop

- Gunakan Herd untuk PHP runtime
- Gunakan Docker Desktop untuk MySQL
- Cocok untuk pengembangan harian di Apple Silicon

### Full Docker Compose

- Gunakan `docker compose up --build`
- Service yang tersedia:
  - `app`
  - `mysql`

## Kebutuhan Server Production

- PHP 8.2+
- MySQL 8+
- Nginx atau Apache
- Composer
- Node.js

## Langkah Singkat Production

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --force --seed
```

Pastikan `APP_ENV=production`, `APP_DEBUG=false`, dan konfigurasi database MySQL sudah benar.

Untuk optimasi lanjutan, Octane dapat dipasang. Untuk monitoring, Pulse atau Telescope dapat diaktifkan sesuai kebutuhan.
