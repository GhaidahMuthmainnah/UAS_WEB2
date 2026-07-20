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
            'menus' => Menu::latest()->get(),
            'packages' => Package::latest()->get(),
            'testimonials' => \App\Models\Testimonial::with('customer')->where('is_published', true)->latest()->take(5)->get()
        ]);
    }
}
