# Task 3: Pemesanan Acara (Event Ordering)

## Deskripsi Singkat
Modul inti bagi Klien (Customer) untuk melakukan pemesanan, dan bagi Admin untuk menyetujui, memantau, serta mengelola detail pesanan dan detail acara (event) yang bersangkutan.

## Referensi PRD
- **Fitur Utama:** Pemesanan Acara (Event Ordering).
- **Tabel ERD:** `orders`, `order_items`, `events`, `customers` (sebagai pemesan).

## Instruksi Implementasi

### 1. Struktur Database
- `customers` (jika dipisah dari tabel `users`, pastikan kolom terisi: name, email, phone, address).
- `orders`: `customer_id`, `order_date`, `total_amount`, `status` (Pending, Paid, Cancelled).
- `order_items`: `order_id`, `menu_id` (nullable), `package_id` (nullable), `quantity`, `unit_price`, `subtotal`.
- `events`: `order_id`, `event_name`, `event_date`, `location`, `num_guests`.

### 2. Model & Seeder
- Buat model relasional terkait (HasMany, BelongsTo).
- Buat `OrderSeeder`, `OrderItemSeeder`, `EventSeeder` untuk men-generate minimal 5 pesanan simulasi (lengkap dengan data acara, item yang dipesan, dan nominal).

### 3. Controller & View
- CRUD untuk pesanan.
- UI Khusus Admin: Menampilkan halaman detail (*show*) pesanan yang merangkum keseluruhan data order, list item, dan detail event dalam satu pandangan.
- Fungsi untuk mengubah status pesanan (`Pending` -> `Paid`).
