<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:1000',
            'type' => 'required|in:DP,Pelunasan',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->customer_id != Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Hitung total bayar (Verified)
        $totalPaid = $order->payments()->where('status', 'Verified')->sum('amount');
        $sisaTagihan = $order->total_amount - $totalPaid;

        if ($request->amount > $sisaTagihan && $sisaTagihan > 0) {
            return back()->with('error', 'Jumlah bayar melebihi sisa tagihan.');
        }

        // Upload Gambar
        $path = $request->file('payment_proof')->store('payments', 'public');

        Payment::create([
            'order_id' => $order->id,
            'amount' => $request->amount,
            'payment_proof' => $path,
            'status' => 'Pending',
            'type' => $request->type
        ]);

        return back()->withSuccess('Bukti pembayaran berhasil diunggah dan menunggu verifikasi Admin.');
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:Verified,Rejected'
        ]);

        $payment->update([
            'status' => $request->status
        ]);

        if ($request->status == 'Verified') {
            $order = $payment->order;
            $totalPaid = $order->payments()->where('status', 'Verified')->sum('amount');
            
            if ($totalPaid >= $order->total_amount) {
                $order->update(['status' => 'Paid']);
            }
        }

        return back()->withSuccess('Status pembayaran berhasil di-' . $request->status);
    }
}
