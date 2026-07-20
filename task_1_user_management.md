# Task 1: Manajemen Pengguna & Autentikasi (User Role Management)

## Deskripsi Singkat
Menyesuaikan sistem autentikasi dan manajemen pengguna bawaan Laravel (berdasarkan modul `users` yang sudah ada pada NiceAdmin) agar selaras dengan **PRD.md**. Tujuannya adalah mengimplementasikan Role-Based Access Control (RBAC) yang mengakomodasi tiga peran pengguna utama: Admin, Staff, dan Customer.

## Referensi PRD
- **Target Pengguna:** Pemilik Catering (Admin), Staf Operasional (Staff), Klien (Customer).
- **Kebutuhan Non-Fungsional:** Autentikasi, autorisasi (RBAC), dan hashing password.

## Instruksi Implementasi

### 1. Migrasi Database (Tabel `users`)
- Buka file `database/migrations/0001_01_01_000000_create_users_table.php`.
- Perbarui struktur tabel jika belum sesuai. Pastikan terdapat kolom `role` (atau tipe `enum`/`string`) yang mengakomodasi nilai: `['Admin', 'Staff', 'Customer']` (tambahkan `Superadmin` jika diwajibkan oleh existing).
- Pastikan field bawaan yang dibutuhkan oleh pelanggan (misal: `phone`, `address`) bisa diintegrasikan, atau siapkan tabel relasi terpisah `customers` jika merujuk ke ERD di PRD (Opsional: cukup satukan data dasar di `users` dan tambahkan tabel `customers` yang berelasi `user_id` jika mengikuti ERD secara spesifik). *Catatan: ikuti pola arsitektur yang sudah ada.*

### 2. Seeder & Data Dummy
- Edit `database/seeders/UserSeeder.php`.
- Buat data *dummy* agar visualisasi data bisa dilihat di sistem:
  - 1 Akun Admin (Pemilik Catering).
  - 2 Akun Staf (Logistik/Dapur).
  - 3 Akun Customer (Klien simulasi).
- Gunakan Hash untuk kata sandi (`bcrypt` via `Hash::make('password')`).

### 3. Model `User`
- Sesuaikan `app/Models/User.php`.
- Tambahkan konstanta Role (misal: `const ROLE_ADMIN = 'Admin';`) untuk mencegah *typo*.
- Daftarkan kolom yang baru (jika ada) ke dalam `$fillable`.

### 4. Controller (`UserController.php`)
- Sesuaikan metode `index()` untuk menampilkan daftar pengguna beserta *badge* peran (*role*) yang relevan.
- Sesuaikan metode `create()` dan `store()` agar menyediakan input peran (dropdown) saat menambah pengguna baru. Validasi role dengan ketat.
- Sesuaikan metode `edit()` dan `update()` agar mengenali dan bisa memodifikasi role. Pastikan pengguna tidak bisa mengubah role ke sistem yang tidak sah.
- Pertahankan struktur, standar *coding style*, konvensi penamaan, dan mekanisme validasi form yang *existing* pada `UserController` bawaan. Dilarang membuat pola baru (misal memisahkan logic menjadi service pattern bila belum ada).

### 5. Tampilan (Blade Views)
- Sesuaikan `resources/views/user/*.blade.php` (index, create, edit, show).
- Tambahkan input/kolom `role` dan berikan pewarnaan visual (misal badge hijau untuk Admin, biru untuk Staff, kuning untuk Customer) mengikuti *class* bawaan NiceAdmin/Bootstrap.

**Catatan:** Dilarang memulai proses *coding* sebelum dokumen ini disetujui.
