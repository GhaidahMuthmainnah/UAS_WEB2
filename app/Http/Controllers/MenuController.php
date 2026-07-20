<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        return view('menu.index', [
            'title' => 'Katalog Menu',
            'menus' => Menu::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('menu.create', [
            'title' => 'Tambah Menu',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        $validate['is_available'] = $request->has('is_available');

        Menu::create($validate);
        return redirect()->route('menu.index')->withSuccess('Menu berhasil ditambahkan');
    }

    public function edit(Menu $menu)
    {
        return view('menu.edit', [
            'title' => 'Edit Menu',
            'menu' => $menu,
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        $validate['is_available'] = $request->has('is_available');

        $menu->update($validate);
        return redirect()->route('menu.index')->withSuccess('Menu berhasil diubah');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->withSuccess('Menu berhasil dihapus');
    }
}
