# Task 2: Manajemen Katalog Menu & Paket (Menus & Packages)

## Deskripsi Singkat
Mengembangkan modul katalog produk yang berisi menu satuan dan paket katering. Ini merupakan master data utama dari sistem yang akan dipilih oleh Customer.

## Referensi PRD
- **Fitur Utama:** Katalog Menu & Paket.
- **Tabel ERD:** `menus` dan `packages`.

## Instruksi Implementasi

### 1. Struktur Database
- Buat file migrasi untuk tabel `menus`: `name`, `description`, `price` (decimal), `is_available` (boolean).
- Buat file migrasi untuk tabel `packages`: `name`, `description`, `total_price` (decimal).
- Pastikan berelasi opsional (many-to-many jika paket terdiri dari spesifik menu, namun di ERD PRD, `menus` dan `packages` langsung terhubung ke `order_items`. Ikuti desain ERD PRD persis).

### 2. Model & Seeder
- Buat Model `Menu` dan `Package`.
- Buat `MenuSeeder` (Minimal 10 menu dummy dengan variasi harga).
- Buat `PackageSeeder` (Minimal 3 paket dummy, misal Paket Pernikahan, Paket Rapat).
- Panggil seeder ini di `DatabaseSeeder.php`.

### 3. Controller & View
- Buat `MenuController` dan `PackageController` menggunakan standar pola `UserController` yang ada (metode CRUD lengkap).
- Desain antarmuka admin (daftar menu, form tambah/edit menu).
- Sesuaikan tampilan list menggunakan tabel bawaan NiceAdmin.
