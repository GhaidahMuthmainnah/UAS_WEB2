<?php

namespace App\Http\Controllers;

use App\Models\DeliverySchedule;
use Illuminate\Http\Request;

class DeliveryScheduleController extends Controller
{
    public function index()
    {
        return view('delivery.index', [
            'title' => 'Dashboard Pengiriman Logistik',
            'deliveries' => DeliverySchedule::with(['order.customer', 'order.event'])
                            ->orderBy('delivery_time', 'asc')
                            ->get(),
        ]);
    }

    public function updateStatus(Request $request, DeliverySchedule $delivery)
    {
        $request->validate([
            'status' => 'required|in:Scheduled,EnRoute,Delivered'
        ]);

        $delivery->update([
            'status' => $request->status
        ]);

        return redirect()->route('delivery.index')->withSuccess('Status pengiriman berhasil diperbarui!');
    }
}
