# Task 4: Penjadwalan Pengiriman (Delivery Scheduling)

## Deskripsi Singkat
Mengelola logistik dan pengiriman makanan ke lokasi acara. Modul ini difokuskan bagi Staf (Logistik) dan Admin.

## Referensi PRD
- **Fitur Utama:** Penjadwalan Pengiriman.
- **Tabel ERD:** `delivery_schedules`.

## Instruksi Implementasi

### 1. Struktur Database
- Tabel `delivery_schedules`: `order_id` (Foreign Key), `delivery_time` (Datetime), `status` (Scheduled, EnRoute, Delivered), `driver_name` (String).

### 2. Model & Seeder
- Model `DeliverySchedule`.
- `DeliveryScheduleSeeder`: Buat simulasi jadwal pengiriman berdasarkan data `orders` yang dibuat pada Task 3. Masukkan variasi status (sedang diantar, sudah sampai).

### 3. Controller & View
- Halaman (List) untuk melacak jadwal pengiriman pada hari tersebut.
- Fitur "Ubah Status" pengiriman secara instan bagi staf yang bisa diakses via *mobile device* (UX Responsif).
