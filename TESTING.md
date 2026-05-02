# Testing SI Qurban

## Automated Test

Jalankan seluruh feature test:

```bash
php artisan test
```

## Skenario Utama yang Dicakup

- Register panitia berhasil
- Register gagal saat email duplikat
- Login admin berhasil
- Login gagal saat kredensial salah
- CRUD admin untuk user, wilayah, dan kupon
- Verifikasi kupon oleh panitia

## Pengujian Manual

- Buka `/register` lalu buat akun panitia baru
- Login sebagai admin dan tambahkan user, wilayah, serta kupon
- Login sebagai panitia lalu verifikasi kupon pada menu `Verifikasi Kupon`
- Cek laporan dan ekspor CSV pada dashboard admin
