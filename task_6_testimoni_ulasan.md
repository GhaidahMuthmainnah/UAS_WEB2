# Task 6: Testimoni & Ulasan (Testimonials)

## Deskripsi Singkat
Fungsionalitas Klien (Customer) untuk memberikan ulasan (rating dan teks) pada layanan pesanan yang telah selesai. Ulasan ini akan dilihat oleh Admin dan mungkin ditampilkan di halaman publik/landing page.

## Referensi PRD
- **Fitur Utama:** Testimoni & Ulasan.
- **Tabel ERD:** `testimonials`.

## Instruksi Implementasi

### 1. Struktur Database
- Tabel `testimonials`: `customer_id` (Foreign Key), `rating` (Integer 1-5), `review` (Text). (Bisa ditambahkan field boolean `is_published` jika Admin perlu mengontrol tampilannya di publik, opsi tambahan jika relevan).

### 2. Model & Seeder
- Model `Testimonial`.
- `TestimonialSeeder`: Berikan 5 data ulasan tiruan dari klien simulasi dengan *rating* tinggi.

### 3. Controller & View
- Klien: Form ringkas untuk menyubmit *rating* & *review*.
- Admin: Tabel untuk melihat semua *review* yang masuk, terhubung ke profil klien di modul Pengguna.
