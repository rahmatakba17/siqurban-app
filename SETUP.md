# Setup SI Qurban

## Prasyarat

- macOS dengan Apple Silicon seperti MacBook M2 didukung
- PHP 8.2+ atau Laravel Herd
- Composer
- Node.js dan npm
- MySQL 8 atau Docker Desktop

## Opsi A: Herd + MySQL Docker

1. Jalankan MySQL:

```bash
docker run --name siqurban-mysql \
  -e MYSQL_ROOT_PASSWORD=root \
  -e MYSQL_DATABASE=siqurban \
  -p 3306:3306 \
  -d mysql:8
```

2. Siapkan Laravel:

```bash
cp .env.example .env
php artisan key:generate
composer install
npm install
```

3. Atur `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siqurban
DB_USERNAME=root
DB_PASSWORD=root
```

4. Jalankan migrasi dan asset:

```bash
php artisan migrate --seed
npm run build
php artisan serve
```

## Opsi B: Full Docker Compose

1. Siapkan environment Docker:

```bash
cp .env.docker.example .env.docker
```

2. Jalankan:

```bash
docker compose up --build
```

3. Akses:

```text
http://localhost:8000
```

Catatan:
- Container app memakai `PHP 8.4` agar cocok dengan dependency saat ini.
- Build asset frontend di host dengan `npm install && npm run build` sebelum menyalakan Docker Compose bila folder `public/build` belum ada.
- Sisakan ruang kosong host minimal `4 GB` untuk menghindari Docker Desktop gagal start di macOS.
- Jika sebelumnya sudah gagal pada image lama, jalankan ulang dengan:

```bash
docker compose down
docker compose up --build
```

## Akun Seeder

- Admin: `admin@siqurban.local`
- Password: `password`
