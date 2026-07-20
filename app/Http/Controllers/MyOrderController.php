<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['event'])
            ->where('customer_id', Auth::id())
            ->latest()
            ->get();

        return view('myorder.index', [
            'title' => 'Riwayat Pesanan Saya',
            'orders' => $orders,
        ]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        if ($order->customer_id != Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $order->load(['customer', 'event', 'items.menu', 'items.package', 'deliverySchedule']);
        
        return view('myorder.show', [
            'title' => 'Faktur / Rincian Pesanan',
            'order' => $order,
        ]);
    }
}
