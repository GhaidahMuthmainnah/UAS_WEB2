<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index', [
            'title' => 'Daftar Pesanan (Orders)',
            'orders' => Order::with(['customer', 'event'])->latest()->get(),
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'event', 'items.menu', 'items.package']);
        
        return view('order.show', [
            'title' => 'Detail Pesanan',
            'order' => $order,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Paid,Cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->route('order.show', $order)->withSuccess('Status pesanan berhasil diubah!');
    }
}
