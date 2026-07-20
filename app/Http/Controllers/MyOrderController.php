<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use App\Models\Package;
use App\Models\OrderItem;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function index()
    {
        return view('myorder.index', [
            'title' => 'Riwayat Pesanan Saya',
            'orders' => Order::with('event')->where('customer_id', Auth::id())->latest()->get(),
            'menus' => Menu::where('is_available', true)->get(),
            'packages' => Package::all(),
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

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'location' => 'required|string',
            'num_guests' => 'required|integer|min:10',
            'product_type' => 'required|in:menu,package',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        // Cek harga item
        $unitPrice = 0;
        if ($request->product_type === 'menu') {
            $product = Menu::findOrFail($request->product_id);
            $unitPrice = $product->price;
        } else {
            $product = Package::findOrFail($request->product_id);
            $unitPrice = $product->total_price;
        }

        $subtotal = $unitPrice * $request->quantity;

        // 1. Buat Order
        $order = Order::create([
            'customer_id' => Auth::id(),
            'order_date' => date('Y-m-d'),
            'total_amount' => $subtotal,
            'status' => 'Pending',
        ]);

        // 2. Buat Event Detail
        Event::create([
            'order_id' => $order->id,
            'event_name' => $request->event_name,
            'event_date' => \Carbon\Carbon::parse($request->event_date),
            'location' => $request->location,
            'num_guests' => $request->num_guests,
        ]);

        // 3. Buat Order Item
        OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => $request->product_type === 'menu' ? $product->id : null,
            'package_id' => $request->product_type === 'package' ? $product->id : null,
            'quantity' => $request->quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $subtotal,
        ]);

        return redirect()->route('myorder.index')->withSuccess('Yeay! Pesanan berhasil dibuat dan sedang menunggu konfirmasi admin.');
    }
}
