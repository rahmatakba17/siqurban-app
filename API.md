# API Pendukung SI Qurban

API tetap tersedia sebagai pelengkap melalui Laravel Sanctum, tetapi fokus utama proyek ini adalah aplikasi web berbasis Blade.

## Endpoint Autentikasi

- `POST /api/login`
- `POST /api/register`
- `POST /api/logout`

## Endpoint Inti

- `GET /api/coupons`
- `POST /api/coupons`
- `GET /api/coupons/{coupon}`
- `POST /api/coupons/{coupon}/scan`
- `GET /api/regions`
- `POST /api/regions`
- `PUT /api/regions/{region}`
- `DELETE /api/regions/{region}`
- `GET /api/reports`
- `GET /api/reports/summary`
- `GET /api/reports/export`

## Autentikasi

Gunakan bearer token dari Sanctum:

```http
Authorization: Bearer {token}
```
