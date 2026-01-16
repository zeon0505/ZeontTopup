# Admin Dashboard Guide

## Akses Admin Dashboard

### Login sebagai Admin
Setelah seeding database, gunakan kredensial berikut:

- **Email:** `admin@example.com`
- **Password:** `password`

Ketika admin login, sistem akan otomatis mengarahkan ke **Admin Dashboard** (`/admin/dashboard`)

### Login sebagai User Biasa
- **Email:** `test@example.com`
- **Password:** `password`

User biasa akan diarahkan ke **User Dashboard** (`/dashboard`)

## Fitur Admin Dashboard

Admin dashboard memiliki 5 tab utama untuk mengelola semua aspek website:

### 1. **Games Tab** (Default)
Kelola semua game yang tersedia:
- ✅ Tambah game baru
- ✅ Upload gambar game
- ✅ Edit nama, slug, dan deskripsi
- ✅ Set urutan tampilan (sort order)
- ✅ Aktifkan/nonaktifkan game
- ✅ Hapus game

### 2. **Products Tab**
Kelola produk untuk setiap game:
- ✅ Tambah produk baru (diamonds, UC, etc)
- ✅ Set harga dan diskon
- ✅ Kelola stok
- ✅ Edit dan hapus produk

### 3. **Orders Tab**
Monitor dan kelola pesanan:
- ✅ Lihat semua pesanan
- ✅ Filter berdasarkan status
- ✅ Update status pesanan
- ✅ Lihat detail pesanan lengkap

### 4. **Users Tab**
Kelola pengguna:
- ✅ Tambah user baru
- ✅ Edit informasi user
- ✅ Reset password
- ✅ Hapus user
- ✅ Lihat jumlah pesanan per user

### 5. **API Settings Tab**
Kelola konfigurasi API provider:
- ✅ Tambah provider baru
- ✅ Set API key dan secret
- ✅ Konfigurasi endpoint
- ✅ Aktifkan/nonaktifkan provider

## Struktur Routing

### User Routes
- `/` - Homepage
- `/games` - Halaman semua game
- `/order/{slug}` - Halaman order game
- `/dashboard` - User dashboard

### Admin Routes
- `/admin/dashboard` - Admin dashboard (Protected)

### Auto-Redirect System
Sistem akan otomatis mengarahkan user berdasarkan role:
- Admin → `/admin/dashboard`
- User biasa → `/dashboard`

## Keamanan

- Admin dashboard dilindungi dengan middleware `auth`
- Hanya user dengan `is_admin = true` yang bisa akses
- Non-admin akan mendapat error 403 jika mencoba akses `/admin/dashboard`

## Tips Penggunaan

1. **Tambah Game Dulu:** Sebelum menambah produk, pastikan game sudah ada
2. **Upload Gambar:** File gambar akan tersimpan di `storage/app/public/games`
3. **Storage Link:** Pastikan `php artisan storage:link` sudah dijalankan
4. **Slug Otomatis:** Saat menambah game, slug akan otomatis dibuat dari nama
5. **Live Search:** Semua tab memiliki fitur pencarian dan filtering real-time

## Troubleshooting

### Jika gambar tidak muncul:
```bash
php artisan storage:link
```

### Jika ingin reset database:
```bash
php artisan migrate:fresh --seed
```

### Membuat admin baru secara manual:
```bash
php artisan tinker
>>> $user = App\Models\User::find(1);
>>> $user->is_admin = true;
>>> $user->save();
```
