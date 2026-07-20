<?php

namespace Database\Seeders;

use App\Models\ExpenseRecord;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ExpenseRecordSeeder extends Seeder
{
    public function run(): void
    {
        // Pengeluaran Rutin (tanpa order_id)
        ExpenseRecord::create([
            'category' => 'Operasional',
            'amount' => 500000,
            'expense_date' => Carbon::now()->subDays(5),
            'description' => 'Tagihan Listrik Bulan Ini',
        ]);
        
        ExpenseRecord::create([
            'category' => 'Logistik',
            'amount' => 150000,
            'expense_date' => Carbon::now()->subDays(2),
            'description' => 'Bensin Armada Pengiriman',
        ]);

        // Pengeluaran terkait pesanan
        $orders = Order::inRandomOrder()->limit(3)->get();
        
        foreach ($orders as $order) {
            ExpenseRecord::create([
                'order_id' => $order->id,
                'category' => 'Vendor Eksternal',
                'amount' => rand(100, 500) * 1000, // 100rb - 500rb
                'expense_date' => Carbon::now()->subDays(rand(1, 10)),
                'description' => 'Sewa Peralatan Tambahan (Meja & Kursi)',
            ]);
        }
    }
}
