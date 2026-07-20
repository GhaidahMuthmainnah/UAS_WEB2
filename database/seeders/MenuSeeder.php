<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['name' => 'Nasi Putih', 'description' => 'Nasi putih pulen porsi standar', 'price' => 5000, 'is_available' => true],
            ['name' => 'Rendang Sapi', 'description' => 'Rendang daging sapi empuk khas Padang', 'price' => 25000, 'is_available' => true],
            ['name' => 'Ayam Goreng Lengkuas', 'description' => 'Ayam goreng dengan bumbu lengkuas gurih', 'price' => 15000, 'is_available' => true],
            ['name' => 'Sambal Goreng Ati', 'description' => 'Sambal goreng hati sapi campur kentang', 'price' => 18000, 'is_available' => true],
            ['name' => 'Sayur Sop Bakso', 'description' => 'Sayur sop segar dengan bakso sapi', 'price' => 12000, 'is_available' => true],
            ['name' => 'Mie Goreng Spesial', 'description' => 'Mie goreng dengan telur dan sayuran', 'price' => 15000, 'is_available' => true],
            ['name' => 'Capcay Seafood', 'description' => 'Capcay sayur lengkap dengan seafood', 'price' => 20000, 'is_available' => true],
            ['name' => 'Kerupuk Udang', 'description' => 'Kerupuk udang renyah', 'price' => 3000, 'is_available' => true],
            ['name' => 'Puding Coklat', 'description' => 'Puding coklat lembut manis', 'price' => 7000, 'is_available' => true],
            ['name' => 'Es Buah Segar', 'description' => 'Es campur aneka buah segar', 'price' => 10000, 'is_available' => true],
        ];

        foreach ($menus as $menu) {
            \App\Models\Menu::create($menu);
        }
    }
}
