<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        return view('ingredient.index', [
            'title' => 'Manajemen Bahan Baku (Inventory)',
            'ingredients' => Ingredient::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'cost_per_unit' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        Ingredient::create($validated);
        return redirect()->route('ingredient.index')->withSuccess('Bahan baku berhasil ditambahkan!');
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'cost_per_unit' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $ingredient->update($validated);
        return redirect()->route('ingredient.index')->withSuccess('Bahan baku berhasil diupdate!');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('ingredient.index')->withSuccess('Bahan baku dihapus!');
    }
}
