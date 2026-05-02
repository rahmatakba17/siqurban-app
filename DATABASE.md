# Struktur Database SI Qurban

## Tabel Inti

### `users`

- `id`
- `name`
- `email`
- `password`
- `phone`
- `role`
- `status`
- `remember_token`
- `created_at`
- `updated_at`

### `regions`

- `id`
- `name`
- `description`
- `status`
- `created_at`
- `updated_at`

### `coupons`

- `id`
- `code`
- `qr_code`
- `type`
- `sacrificer_name`
- `special_request`
- `region_id`
- `status`
- `received_by`
- `received_at`
- `created_at`
- `updated_at`

### `scan_histories`

- `id`
- `coupon_id`
- `user_id`
- `scan_time`
- `notes`
- `created_at`
- `updated_at`

### `settings`

- `id`
- `key`
- `value`
- `created_at`
- `updated_at`

### `personal_access_tokens`

Digunakan Sanctum untuk API authentication pendukung.

## Relasi

- `users` hasMany `scan_histories`
- `regions` hasMany `coupons`
- `coupons` belongsTo `regions`
- `coupons` hasMany `scan_histories`
- `scan_histories` belongsTo `users`
- `scan_histories` belongsTo `coupons`
