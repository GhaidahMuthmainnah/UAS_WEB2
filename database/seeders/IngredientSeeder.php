<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Beras Premium', 'unit' => 'kg', 'cost_per_unit' => 15000, 'stock_quantity' => 250],
            ['name' => 'Ayam Potong', 'unit' => 'kg', 'cost_per_unit' => 35000, 'stock_quantity' => 100],
            ['name' => 'Daging Sapi', 'unit' => 'kg', 'cost_per_unit' => 120000, 'stock_quantity' => 50],
            ['name' => 'Telur Ayam', 'unit' => 'papan', 'cost_per_unit' => 55000, 'stock_quantity' => 30],
            ['name' => 'Minyak Goreng', 'unit' => 'liter', 'cost_per_unit' => 18000, 'stock_quantity' => 120],
            ['name' => 'Bawang Merah', 'unit' => 'kg', 'cost_per_unit' => 30000, 'stock_quantity' => 20],
            ['name' => 'Gula Pasir', 'unit' => 'kg', 'cost_per_unit' => 16000, 'stock_quantity' => 40],
        ];

        foreach ($ingredients as $ing) {
            Ingredient::create($ing);
        }
    }
}
