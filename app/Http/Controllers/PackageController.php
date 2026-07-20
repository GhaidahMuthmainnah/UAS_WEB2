<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        return view('package.index', [
            'title' => 'Katalog Paket',
            'packages' => Package::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('package.create', [
            'title' => 'Tambah Paket',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_price' => 'required|numeric|min:0',
        ]);

        Package::create($validate);
        return redirect()->route('package.index')->withSuccess('Paket berhasil ditambahkan');
    }

    public function edit(Package $package)
    {
        return view('package.edit', [
            'title' => 'Edit Paket',
            'package' => $package,
        ]);
    }

    public function update(Request $request, Package $package)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_price' => 'required|numeric|min:0',
        ]);

        $package->update($validate);
        return redirect()->route('package.index')->withSuccess('Paket berhasil diubah');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('package.index')->withSuccess('Paket berhasil dihapus');
    }
}
