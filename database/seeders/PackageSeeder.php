<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            ['name' => 'Paket Prasmanan Reguler', 'description' => 'Paket prasmanan dengan 5 macam lauk dan pencuci mulut', 'total_price' => 5000000],
            ['name' => 'Paket Pernikahan Premium', 'description' => 'Paket pernikahan lengkap dengan pondokan dan dekorasi makanan', 'total_price' => 15000000],
            ['name' => 'Paket Nasi Kotak Hemat', 'description' => 'Nasi kotak untuk acara seminar (Minimal 50 box)', 'total_price' => 1000000],
        ];

        foreach ($packages as $package) {
            \App\Models\Package::create($package);
        }
    }
}
