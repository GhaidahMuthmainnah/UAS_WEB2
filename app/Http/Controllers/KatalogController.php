<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Package;

class KatalogController extends Controller
{
    public function index()
    {
        return view('katalog.index', [
            'title' => 'Katalog Menu & Paket',
            'menus' => Menu::where('is_available', true)->get(),
            'packages' => Package::all(),
        ]);
    }
}
