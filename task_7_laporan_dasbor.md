# Task 7: Laporan & Dasbor (Reports & Dashboard)

## Deskripsi Singkat
Modul visualisasi data yang krusial bagi Admin untuk memantau performa dan profitabilitas bisnis.

## Referensi PRD
- **Fitur Utama:** Laporan & Dasbor.
- **Kebutuhan Non-Fungsional:** Kinerja kalkulasi yang cepat (di bawah 3 detik).

## Instruksi Implementasi

### 1. Model & Logika Query (Logika Bisnis)
- Agregasi data di Controller (misal `DashboardController`).
- Buat query statistik:
  1. Total Pesanan (bulan ini vs bulan lalu).
  2. Total Pendapatan (*Revenue*) dari status `Paid`.
  3. Total Pengeluaran (*Expenses*).
  4. Profit Bersih = Pendapatan - Pengeluaran.
  5. Rata-rata Rating Klien.

### 2. Controller & View
- Tampilkan agregasi tersebut pada halaman `Dashboard`.
- Modifikasi halaman depan dasbor NiceAdmin menggunakan komponen *card* dan *chart* statis/dinamis yang relevan.
- Gunakan data *dummy* dari seeder yang sudah dibuat pada task-task sebelumnya agar *chart* dan *card* memiliki nilai visual yang representatif.
