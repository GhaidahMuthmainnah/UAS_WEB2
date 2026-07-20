# Task 8: Sistem Pembayaran Bertahap (Term of Payment / DP)

## Deskripsi Singkat
Modul tingkat lanjut untuk memfasilitasi transaksi bernilai besar. Sistem ini mengizinkan Klien melakukan pembayaran secara mencicil (termin), seperti pembayaran uang muka (*Down Payment* / DP) untuk mengamankan tanggal acara, dan pelunasan menjelang atau sesudah acara selesai. 

## Referensi PRD
- **Fitur Tambahan (Advanced):** Pemesanan Acara & Transaksi Finansial.
- **Tabel ERD (Penambahan):** Perlu entitas baru `payments` yang berelasi dengan `orders`.

## Instruksi Implementasi

### 1. Struktur Database
- Tabel baru `payments`:
  - `order_id` (Foreign Key).
  - `payment_type` (Enum: `DP`, `Termin 2`, `Pelunasan`).
  - `amount_paid` (Decimal).
  - `payment_date` (Date/Datetime).
  - `proof_of_payment` (String/Text - Path gambar bukti transfer).
  - `status` (Enum: `Pending`, `Verified`, `Rejected`).
- *Update* tabel `orders`: Tambahkan field `outstanding_amount` (sisa tagihan) atau biarkan dikalkulasi secara dinamis berdasarkan total `orders` dikurangi total `amount_paid` dari tabel `payments`. 

### 2. Model & Seeder
- Buat Model `Payment` yang terhubung secara *BelongsTo* ke `Order`.
- Buat `PaymentSeeder`:
  - Generate data simulasi di mana sebagian pesanan (*orders*) baru dibayar DP 30%.
  - Sebagian pesanan lainnya sudah lunas (memiliki 2 atau 3 entri pembayaran: DP, Pelunasan).

### 3. Controller & View
- **Sisi Klien (Customer):** 
  - Tampilan rincian pesanan yang memperlihatkan **Total Harga**, **Sudah Dibayar**, dan **Sisa Tagihan**.
  - Form untuk "Bayar Tagihan" (unggah gambar bukti transfer).
- **Sisi Admin:**
  - Halaman untuk memverifikasi pembayaran yang masuk (Mengubah status dari `Pending` ke `Verified`).
  - Laporan piutang otomatis bagi Admin untuk melacak pesanan mana saja yang acaranya sudah dekat namun belum lunas.

**Catatan:** Dilarang memulai proses *coding* sebelum dokumen ini disetujui.
