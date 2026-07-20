<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    // Admin View
    public function index()
    {
        return view('testimonial.index', [
            'title' => 'Moderasi Ulasan Klien',
            'testimonials' => Testimonial::with('customer')->latest()->get()
        ]);
    }

    // Admin Action
    public function updateStatus(Request $request, Testimonial $testimonial)
    {
        $testimonial->update([
            'is_published' => $request->has('is_published')
        ]);

        return redirect()->route('testimonial.index')->withSuccess('Status ulasan diperbarui!');
    }

    // Admin Action
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('testimonial.index')->withSuccess('Ulasan berhasil dihapus.');
    }

    // Customer Action
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10',
        ]);

        Testimonial::create([
            'customer_id' => Auth::id(),
            'rating' => $request->rating,
            'review' => $request->review,
            'is_published' => false // Menunggu moderasi
        ]);

        return back()->withSuccess('Ulasan berhasil dikirim! Menunggu moderasi admin sebelum dipublikasikan.');
    }
}
