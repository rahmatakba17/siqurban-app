# SI Qurban

SI Qurban adalah aplikasi web berbasis Laravel 11 untuk mendukung distribusi kupon kurban secara tertib, terdokumentasi, dan mudah dioperasikan oleh admin maupun panitia. Proyek ini disusun sebagai tugas mahasiswa Magister Teknik Informatika semester 2 pada mata kuliah Rekayasa Perangkat Lunak.

## Stack

- Backend: Laravel 11
- Frontend: Blade, HTML, CSS, TailwindCSS
- Database: MySQL
- Pendukung: Sanctum, Reverb, Pulse/Telescope, Octane, Livewire sebagai opsi pengembangan lanjutan

## Fitur Utama

- Login dan register berbasis session Laravel
- Dashboard admin dan dashboard panitia
- CRUD user, wilayah, dan kupon
- Validasi form menggunakan Form Request
- Verifikasi kupon oleh panitia
- Desain responsif dengan TailwindCSS
- Export laporan CSV

## Jalankan di MacBook M2

### Opsi 1: Laravel Herd + MySQL dari Docker Desktop

Opsi ini paling nyaman untuk pengembangan di macOS Apple Silicon.

1. Jalankan container MySQL:

```bash
docker run --name siqurban-mysql \
  -e MYSQL_ROOT_PASSWORD=root \
  -e MYSQL_DATABASE=siqurban \
  -p 3306:3306 \
  -d mysql:8
```

2. Siapkan environment Laravel:

```bash
cp .env.example .env
php artisan key:generate
```

3. Pastikan `.env` memakai konfigurasi berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siqurban
DB_USERNAME=root
DB_PASSWORD=root
```

4. Jalankan aplikasi:

```bash
composer install
npm install
php artisan migrate --seed
npm run build
php artisan serve
```

Jika folder ini dibuka lewat Herd, Anda juga bisa menjalankannya langsung dari domain lokal Herd.

### Opsi 2: Full Docker Desktop

1. Siapkan file environment Docker:

```bash
cp .env.docker.example .env.docker
```

2. Jalankan seluruh stack:

```bash
docker compose up --build
```

3. Akses aplikasi di:

```text
http://localhost:8000
```

Catatan:
- Image Docker proyek ini memakai `PHP 8.4`.
- Asset frontend harus sudah tersedia di `public/build`. Jika belum, jalankan `npm install && npm run build` di host terlebih dahulu.
- Sisakan ruang kosong host minimal `4 GB` agar Docker Desktop stabil di macOS. Saat ruang terlalu sempit, engine Docker bisa gagal start dengan error `no space left on device`.
- Jika Anda sebelumnya sudah sempat build image lama dan mendapat error `You are running 8.3.x`, lakukan rebuild penuh.

```bash
docker compose down
docker compose up --build
```

Container `app` akan otomatis:

- install dependency Composer bila perlu
- install ulang dependency Composer bila `vendor` tidak cocok dengan versi PHP container
- generate app key
- migrate dan seed database
- menjalankan Laravel di port `8000`

## File Docker yang Tersedia

- `Dockerfile`
- `docker-compose.yml`
- `.env.docker.example`
- `docker/start-container.sh`

## Struktur Dokumen

- Laporan akademik: `docs/laporan.md`
- Panduan setup: `SETUP.md`
- Ringkasan API pendukung: `API.md`
- Struktur database: `DATABASE.md`
- Panduan pengujian teknis: `TESTING.md`
- Panduan deployment: `DEPLOYMENT.md`

## Testing

```bash
php artisan test
```
