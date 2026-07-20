<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Verifikasi kepemilikan jika user adalah Customer
        if (Auth::user()->role === 'Customer' && $order->customer_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        Chat::create([
            'order_id' => $order->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_read' => false
        ]);

        return back()->withSuccess('Pesan terkirim.');
    }

    public function index()
    {
        // Ambil semua order yang memiliki chat, urutkan berdasarkan chat terbaru
        $orders = Order::whereHas('chats')->with(['customer', 'chats' => function($q) {
            $q->latest();
        }])->get()->sortByDesc(function($order) {
            return $order->chats->first()->created_at;
        });

        return view('chat.index', [
            'title' => 'Pusat Pesan (Live Chat)',
            'orders' => $orders
        ]);
    }

    public function show(Order $order)
    {
        return view('chat.show', [
            'title' => 'Live Chat Order #' . str_pad($order->id, 5, '0', STR_PAD_LEFT),
            'order' => $order
        ]);
    }
}
