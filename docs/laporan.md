# Laporan Proyek Rekayasa Perangkat Lunak

## Judul

**Perancangan dan Implementasi Aplikasi Web SI Qurban**  
Menggunakan Laravel 11, TailwindCSS, MySQL, Docker, dan QR Code

---

## Latar Belakang

Distribusi daging kurban pada banyak lembaga masih dilakukan secara manual menggunakan daftar cetak dan pencatatan sederhana. Pendekatan tersebut sering menimbulkan masalah berupa duplikasi data, kesalahan verifikasi penerima, antrian tidak tertib, serta kesulitan saat membuat laporan akhir.

SI Qurban dikembangkan sebagai solusi digital untuk membantu admin dan panitia dalam mengelola data user, wilayah distribusi, kupon QR Code, dan riwayat verifikasi. Proyek ini dirancang relevan dengan kebutuhan pembelajaran pada mata kuliah Rekayasa Perangkat Lunak, khususnya dalam aspek analisis kebutuhan, implementasi sistem, pengujian, dan dokumentasi teknis.

---

## Rumusan Masalah

1. Bagaimana merancang aplikasi web yang mampu mengelola distribusi kupon kurban secara terstruktur?
2. Bagaimana mengimplementasikan QR Code nyata (SVG) pada setiap kupon untuk verifikasi saat pembagian?
3. Bagaimana menyediakan fitur scan QR Code via kamera browser tanpa aplikasi tambahan?
4. Bagaimana mendokumentasikan proses pengembangan menggunakan UML dan Agile Scrum?

---

## Tujuan

1. Menghasilkan aplikasi SI Qurban berbasis web menggunakan Laravel 11, TailwindCSS, dan MySQL.
2. Menyediakan QR Code SVG nyata untuk setiap kupon dan scanner via kamera browser.
3. Menyusun dokumentasi teknis UML lengkap (Use Case, Class, Sequence, ERD, Activity, Component, Deployment, State Machine).
4. Mendeploy aplikasi menggunakan Docker Desktop dengan phpMyAdmin terintegrasi.

---

## Pembahasan

### Deskripsi Sistem

SI Qurban mendukung dua jenis kupon:
- **Kupon Pengkurban**: berisi nama dan permintaan khusus pengkurban.
- **Kupon Umum**: hanya berisi nomor/kode kupon untuk masyarakat umum.

Pengguna dibagi dua peran: **Admin** (kontrol penuh) dan **Panitia** (verifikasi kupon).

---

### Metode Pengembangan Agile Scrum

#### Product Backlog

| No | Product Backlog | Prioritas |
| --- | --- | --- |
| 1 | Registrasi dan login user | Tinggi |
| 2 | Dashboard admin dan panitia | Tinggi |
| 3 | CRUD user, wilayah, kupon | Tinggi |
| 4 | Generate kupon otomatis dengan QR Code SVG | Tinggi |
| 5 | Import kupon dari CSV | Tinggi |
| 6 | Scan QR Code via kamera browser | Tinggi |
| 7 | Verifikasi kupon oleh panitia | Tinggi |
| 8 | Laporan distribusi + ekspor CSV & Excel | Sedang |
| 9 | Pengaturan aplikasi (nama masjid, tahun) | Sedang |
| 10 | Profil akun admin & panitia | Sedang |
| 11 | Filter & search kupon | Sedang |
| 12 | Cetak batch kupon | Sedang |
| 13 | Docker multi-stage build + phpMyAdmin | Rendah |

#### Sprint Planning

| Sprint | Aktivitas Utama |
| --- | --- |
| Sprint 1 | Setup Laravel, ERD, auth, layout premium, dashboard awal |
| Sprint 2 | CRUD user/wilayah/kupon, generate QR Code SVG, import CSV |
| Sprint 3 | Scanner QR kamera, verifikasi, laporan Excel, Docker, dokumentasi |

---

### Perancangan Sistem (UML)

#### 1. Use Case Diagram

```mermaid
flowchart LR
    Admin((👤 Admin))
    Panitia((🧾 Panitia))

    subgraph UC_Auth["Autentikasi"]
        UC1[Login]
        UC2[Register]
        UC_Logout[Logout]
    end

    subgraph UC_Admin["Manajemen Admin"]
        UC3[Kelola User]
        UC4[Kelola Wilayah]
        UC5[Kelola Kupon]
        UC6[Generate Kupon Otomatis]
        UC7[Import Kupon CSV]
        UC8[Cetak Kupon QR Code]
        UC9[Cetak Batch Kupon]
        UC10[Kelola Pengaturan Aplikasi]
        UC11[Lihat Riwayat Scan Global]
        UC12[Laporan & Rekapitulasi]
        UC13[Export CSV & Excel]
        UC14[Profil Akun Admin]
    end

    subgraph UC_Panitia["Tugas Panitia"]
        UC15[Dashboard Panitia]
        UC16[Scan QR via Kamera]
        UC17[Input Kode Manual]
        UC18[Lihat Riwayat Scan Pribadi]
        UC19[Profil Akun Panitia]
    end

    Admin --> UC1
    Admin --> UC_Logout
    Admin --> UC3
    Admin --> UC4
    Admin --> UC5
    Admin --> UC6
    Admin --> UC7
    Admin --> UC8
    Admin --> UC9
    Admin --> UC10
    Admin --> UC11
    Admin --> UC12
    Admin --> UC13
    Admin --> UC14

    Panitia --> UC1
    Panitia --> UC2
    Panitia --> UC_Logout
    Panitia --> UC15
    Panitia --> UC16
    Panitia --> UC17
    Panitia --> UC18
    Panitia --> UC19

    UC16 -->|extends| UC17
```

---

#### 2. Class Diagram (UML)

```mermaid
classDiagram
    class User {
        +int id
        +string name
        +string email
        +string password
        +string phone
        +enum role [admin, panitia]
        +enum status [active, inactive]
        +hasMany() ScanHistory
        +login()
        +logout()
        +updateProfile()
    }

    class Region {
        +int id
        +string name
        +text description
        +enum status [active, inactive]
        +hasMany() Coupon
        +getProgressPercent() float
    }

    class Coupon {
        +int id
        +string code
        +text qr_code
        +enum type [umum, pengkurban]
        +string sacrificer_name
        +text special_request
        +int region_id
        +enum status [available, received]
        +string received_by
        +datetime received_at
        +belongsTo() Region
        +hasMany() ScanHistory
        +generateQrSvg() string
        +markReceived()
    }

    class ScanHistory {
        +int id
        +int coupon_id
        +int user_id
        +datetime scan_time
        +text notes
        +belongsTo() Coupon
        +belongsTo() User
    }

    class Setting {
        +int id
        +string key
        +text value
        +static get(key, default) string
        +static set(key, value) void
    }

    class CouponController {
        +index(Request) View
        +generate(Request) RedirectResponse
        +import(Request) RedirectResponse
        +print(Coupon) View
        +printBatch(Request) View
        +generateQrSvg(code) string
        +verify(Request) JsonResponse
    }

    class ScanController {
        +index() View
        +verify(Request) JsonResponse
        +history() View
    }

    User "1" --> "*" ScanHistory : melakukan
    Region "1" --> "*" Coupon : mencakup
    Coupon "1" --> "*" ScanHistory : diverifikasi_oleh
    CouponController ..> Coupon : mengelola
    CouponController ..> Region : membaca
    ScanController ..> Coupon : memverifikasi
    ScanController ..> ScanHistory : mencatat
```

---

#### 3. ERD (Entity Relationship Diagram)

```mermaid
erDiagram
    USERS ||--o{ SCAN_HISTORIES : melakukan
    REGIONS ||--o{ COUPONS : mencakup
    COUPONS ||--o{ SCAN_HISTORIES : diverifikasi

    USERS {
        bigint   id         PK
        string   name
        string   email      UK
        string   password
        string   phone
        enum     role       "admin | panitia"
        enum     status     "active | inactive"
        datetime created_at
        datetime updated_at
    }

    REGIONS {
        bigint   id         PK
        string   name       UK
        text     description
        enum     status     "active | inactive"
        datetime created_at
        datetime updated_at
    }

    COUPONS {
        bigint   id              PK
        string   code            UK
        longtext qr_code         "JSON payload QR"
        enum     type            "umum | pengkurban"
        string   sacrificer_name
        text     special_request
        bigint   region_id       FK
        enum     status          "available | received"
        string   received_by
        datetime received_at
        datetime created_at
        datetime updated_at
    }

    SCAN_HISTORIES {
        bigint   id         PK
        bigint   coupon_id  FK
        bigint   user_id    FK
        datetime scan_time
        text     notes
        datetime created_at
        datetime updated_at
    }

    SETTINGS {
        bigint  id    PK
        string  key   UK
        text    value
    }
```

---

#### 4. Activity Diagram — Proses Verifikasi Kupon

```mermaid
flowchart TD
    Start([Panitia Buka Halaman Scan]) --> A[Pilih Mode: Kamera / Manual]
    A --> B{Mode Dipilih}
    B -- Kamera --> C[Aktifkan Kamera Browser]
    B -- Manual --> D[Input Kode Kupon]
    C --> E[Arahkan ke QR Code]
    E --> F[html5-qrcode Membaca QR]
    F --> G[Extract coupon_code dari payload]
    D --> G
    G --> H[POST /panitia/scan/verify]
    H --> I{Kupon ditemukan?}
    I -- Tidak --> J[Return 404 — Kupon tidak ditemukan]
    I -- Ya --> K{Status kupon?}
    K -- received --> L[Return 422 — Sudah dipakai]
    K -- available --> M[Simpan ScanHistory]
    M --> N[Update status coupon → received]
    N --> O[Return 200 — Sukses + data kupon]
    O --> P[Tampil info penerima & animasi sukses]
    J --> Q[Tampil pesan error merah]
    L --> Q
    P --> R{Scan berikutnya?}
    Q --> R
    R -- Ya --> A
    R -- Tidak --> S([Selesai])
```

---

#### 5. Sequence Diagram — Scan & Verifikasi

```mermaid
sequenceDiagram
    actor Panitia
    participant Browser as Browser (html5-qrcode)
    participant Laravel as Laravel Server
    participant DB as MySQL

    Panitia ->> Browser: Arahkan kamera ke QR Code
    Browser ->> Browser: Decode QR → coupon_code
    Browser ->> Laravel: POST /panitia/scan/verify {coupon_code}
    Laravel ->> DB: SELECT * FROM coupons WHERE code = ?
    DB -->> Laravel: Coupon record

    alt Kupon tidak ditemukan
        Laravel -->> Browser: 404 {message: "Kupon tidak ditemukan"}
        Browser -->> Panitia: ❌ Error merah
    else Kupon sudah diterima
        Laravel -->> Browser: 422 {message: "Kupon sudah dipakai"}
        Browser -->> Panitia: ❌ Error merah
    else Kupon valid & available
        Laravel ->> DB: INSERT INTO scan_histories
        Laravel ->> DB: UPDATE coupons SET status='received', received_by=...
        DB -->> Laravel: OK
        Laravel -->> Browser: 200 {success: true, coupon: {...}}
        Browser -->> Panitia: ✅ Animasi sukses + info penerima
    end
```

---

#### 6. State Machine Diagram — Status Kupon

```mermaid
stateDiagram-v2
    [*] --> available : Kupon dibuat (generate/import)
    available --> received : Panitia scan & verifikasi berhasil
    received --> [*] : Data final (tidak dapat diubah manual)

    available : ✅ Available\n(Belum diambil)
    received  : 📦 Received\n(Sudah diterima)
```

---

#### 7. Component Diagram — Arsitektur Sistem

```mermaid
graph TB
    subgraph Client["🌐 Browser Client"]
        UI[Blade Templates]
        Alpine[Alpine.js - Reaktif]
        QRScan[html5-qrcode - Scanner]
        Chart[Chart.js - Grafik]
        Vite[Vite + TailwindCSS]
    end

    subgraph Server["🖥️ Laravel Server (PHP 8.4)"]
        Router[routes/web.php]
        Middleware[Auth Middleware]
        AdminCtrl[Admin Controllers]
        PanitiaCtrl[Panitia Controllers]
        Models[Eloquent Models]
        QRLib[chillerlan/php-qrcode]
        ExcelLib[phpoffice/phpspreadsheet]
        Sanctum[Laravel Sanctum]
    end

    subgraph Storage["🗄️ Data Layer"]
        MySQL[(MySQL 8.4)]
        FileStorage[Storage - CSV/Excel]
    end

    subgraph Docker["🐳 Docker Compose"]
        AppContainer[siqurban-app:latest]
        MySQLContainer[mysql:8.4]
        PhpMyAdmin[phpmyadmin:latest]
    end

    UI --> Router
    Router --> Middleware
    Middleware --> AdminCtrl
    Middleware --> PanitiaCtrl
    AdminCtrl --> Models
    PanitiaCtrl --> Models
    AdminCtrl --> QRLib
    AdminCtrl --> ExcelLib
    Models --> MySQL
    AdminCtrl --> FileStorage
    AppContainer --> Server
    MySQLContainer --> Storage
    PhpMyAdmin --> MySQLContainer
    QRScan --> Router
    Chart --> UI
    Alpine --> UI
```

---

#### 8. Deployment Diagram — Docker Desktop

```mermaid
graph LR
    subgraph Host["💻 MacOS Host"]
        Browser[Browser\nlocalhost:8000\nlocalhost:8080]
    end

    subgraph Docker["🐳 Docker Desktop"]
        subgraph Network["siqurban_default network"]
            App["siqurban-app\nPHP 8.4 + Laravel\nport: 8000"]
            PMA["siqurban-phpmyadmin\nphpMyAdmin\nport: 8080"]
            DB["siqurban-mysql\nMySQL 8.4\nport: 3306 (internal)"]
        end
        Volume["mysql_data Volume"]
    end

    Browser -->|"HTTP :8000"| App
    Browser -->|"HTTP :8080"| PMA
    App -->|"TCP :3306"| DB
    PMA -->|"TCP :3306"| DB
    DB --- Volume
```

---

### Struktur Database

| Tabel | Fungsi |
|---|---|
| `users` | Akun admin dan panitia |
| `regions` | Wilayah distribusi |
| `coupons` | Data kupon dengan QR code payload |
| `scan_histories` | Log setiap verifikasi kupon |
| `settings` | Konfigurasi aplikasi (nama masjid, tahun) |
| `personal_access_tokens` | Token Sanctum API |
| `password_reset_tokens` | Reset password |

---

### Struktur Folder Laravel

```text
app/
  Http/
    Controllers/
      Admin/
        CouponController.php    ← CRUD + Generate + Import + QR Code
        DashboardController.php ← Dashboard + Pengaturan + Profil Admin
        RegionController.php    ← CRUD Wilayah
        ReportController.php    ← Laporan + Export CSV/Excel
        UserController.php      ← CRUD User
      Panitia/
        DashboardController.php ← Dashboard + Profil Panitia
        ScanController.php      ← Verifikasi Kupon
      Auth/
        AuthController.php      ← Login + Register + Logout
    Requests/
      GenerateCouponRequest.php
      ImportCouponRequest.php
      StoreCouponRequest.php
      UpdateCouponRequest.php
      UpdateSettingsRequest.php
  Models/
    Coupon.php, Region.php, ScanHistory.php, Setting.php, User.php
database/
  migrations/       ← 7 file migrasi
  seeders/
    DatabaseSeeder.php ← Demo data + QR Code
docs/
  laporan.md        ← Dokumen ini
docker/
  start-container.sh
resources/
  css/app.css       ← TailwindCSS + Inter + Animasi
  js/app.js         ← Alpine.js
  views/
    welcome.blade.php    ← Landing page premium dark
    layouts/app.blade.php ← Sidebar + navbar premium
    auth/                ← Login + Register
    admin/               ← Dashboard, User, Wilayah, Kupon, Laporan
    panitia/             ← Dashboard, Scan (QR + Manual), Profil
```

---

### Stack Teknologi

| Layer | Teknologi |
|---|---|
| Backend | Laravel 11, PHP 8.4 |
| Frontend | Blade, TailwindCSS v3, Alpine.js, Vite |
| QR Code | chillerlan/php-qrcode v6 (SVG) |
| QR Scanner | html5-qrcode v2.3 (CDN) |
| Grafik | Chart.js v4 (CDN) |
| Excel | phpoffice/phpspreadsheet v2 |
| Database | MySQL 8.4 |
| Container | Docker Desktop (multi-stage build) |
| Manajemen DB | phpMyAdmin |

---

### Pengujian Black Box Testing

| No | Fitur | Skenario Uji | Input | Output Diharapkan | Status |
| --- | --- | --- | --- | --- | --- |
| 1 | Register | Data valid | Nama, email unik, password | Akun tersimpan, redirect dashboard | ✅ Lulus |
| 2 | Register | Email duplikat | Email sudah ada | Error validasi duplikat | ✅ Lulus |
| 3 | Login | Admin valid | Email+pass admin | Redirect dashboard admin | ✅ Lulus |
| 4 | Login | Password salah | Password keliru | Pesan error login | ✅ Lulus |
| 5 | Generate Kupon | Qty 10 | Wilayah + qty + tipe | 10 kupon tersimpan + QR Code | ✅ Lulus |
| 6 | QR Code | Generate SVG | Kode kupon | SVG QR Code muncul di halaman print | ✅ Lulus |
| 7 | Cetak Kupon | Halaman print | Buka URL print | Kartu kupon premium + QR Code tampil | ✅ Lulus |
| 8 | Cetak Batch | Pilih 5 kupon | Centang + klik cetak batch | 5 kartu kupon muncul di halaman batch | ✅ Lulus |
| 9 | Import CSV | File valid | CSV berformat benar | Kupon tersimpan sesuai jumlah baris | ✅ Lulus |
| 10 | Scan QR Kamera | QR valid | Arahkan kamera | Kupon terverifikasi, status → received | ✅ Lulus |
| 11 | Scan Manual | Kode valid | Input kode di form | Kupon terverifikasi | ✅ Lulus |
| 12 | Scan Duplikat | Kupon sudah dipakai | Scan kupon received | Error "Kupon sudah digunakan" | ✅ Lulus |
| 13 | Filter Kupon | Filter status=received | Pilih filter | Hanya kupon received tampil | ✅ Lulus |
| 14 | Export CSV | Admin klik unduh | Klik tombol CSV | File CSV terunduh dengan BOM UTF-8 | ✅ Lulus |
| 15 | Export Excel | Admin klik unduh | Klik tombol Excel | File .xlsx terunduh dengan styling | ✅ Lulus |
| 16 | Dashboard Chart | Buka dashboard | Login admin | Chart bar distribusi wilayah tampil | ✅ Lulus |
| 17 | Profil Admin | Update profil | Nama + email baru | Data tersimpan, flash sukses | ✅ Lulus |
| 18 | Pengaturan | Ubah nama masjid | Input nama baru | Setting tersimpan, tampil di print | ✅ Lulus |
| 19 | phpMyAdmin | Akses port 8080 | Buka browser | Login phpMyAdmin berhasil | ✅ Lulus |
| 20 | Docker Build | docker compose up | Terminal | App running di port 8000 otomatis | ✅ Lulus |

---

### Cara Menjalankan dengan Docker Desktop

```bash
# 1. Clone & masuk folder
cd KUPON-QURBAN

# 2. Siapkan .env Docker
cp .env.docker.example .env.docker

# 3. Jalankan seluruh stack (build otomatis termasuk frontend)
docker compose up --build

# 4. Akses:
# Aplikasi   → http://localhost:8000
# phpMyAdmin → http://localhost:8080
# Login      → admin@siqurban.local / password
```

---

## Kesimpulan

SI Qurban berhasil dirancang dan diimplementasikan sebagai aplikasi web berbasis Laravel 11 yang memenuhi kebutuhan operasional distribusi daging kurban secara digital. Sistem telah menyediakan:

- **QR Code SVG nyata** pada setiap kupon (bukan sekedar JSON string)
- **Scanner QR Code via kamera browser** tanpa instalasi aplikasi tambahan
- **Dashboard premium** dengan Chart.js, progress bar per wilayah, dan statistik lengkap
- **Ekspor laporan** dalam format CSV dan Excel (.xlsx) dengan styling
- **Docker multi-stage build** yang membangun frontend secara otomatis di dalam container
- **phpMyAdmin terintegrasi** untuk kemudahan manajemen database via browser
- **Dokumentasi UML lengkap**: Use Case, Class, ERD, Activity, Sequence, State Machine, Component, dan Deployment Diagram

Penerapan Agile Scrum dalam tiga sprint membantu pembagian pekerjaan yang terukur. Dari sisi teknis, Laravel mempermudah pengembangan backend, TailwindCSS menghasilkan antarmuka premium yang responsif, dan Docker memastikan reprodusibilitas lingkungan pengembangan dan produksi.
