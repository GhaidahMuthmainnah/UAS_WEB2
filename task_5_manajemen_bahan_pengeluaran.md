# Task 5: Manajemen Bahan Baku & Pengeluaran (Inventory & Expenses)

## Deskripsi Singkat
Mencatat stok bahan makanan serta rekapitulasi arus kas keluar (pengeluaran) untuk menghitung efisiensi dan laba/rugi pesanan.

## Referensi PRD
- **Fitur Utama:** Manajemen Bahan & Biaya, Pengeluaran Operasional.
- **Tabel ERD:** `ingredients`, `expense_records`.

## Instruksi Implementasi

### 1. Struktur Database
- `ingredients`: `name`, `unit`, `cost_per_unit`, `stock_quantity`.
- `expense_records`: `order_id` (Nullable), `category`, `amount`, `expense_date`, `description`.

### 2. Model & Seeder
- Model `Ingredient` dan `ExpenseRecord`.
- `IngredientSeeder`: Data bahan dasar catering (mis: Beras, Ayam, Minyak Goreng).
- `ExpenseRecordSeeder`: Data pengeluaran umum (listrik) dan pengeluaran khusus acara (sewa tenda yang terhubung ke `order_id`).

### 3. Controller & View
- Form CRUD Inventaris dan Pengeluaran.
- Modul "Catat Pengeluaran Baru" yang memiliki opsi atribusi ke pesanan tertentu.
