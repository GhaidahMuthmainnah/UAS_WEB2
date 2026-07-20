<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\DeliverySchedule;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DeliveryScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::whereHas('event')->get();
        $drivers = ['Budi Logistik', 'Agus Kurir', 'Hasan Driver', 'Dodi Ekspedisi'];
        $statuses = ['Scheduled', 'EnRoute', 'Delivered'];

        foreach ($orders as $order) {
            // Kita jadwalkan pengiriman sekitar 2 jam sebelum event
            $deliveryTime = Carbon::parse($order->event->event_date)->subHours(2);
            
            DeliverySchedule::create([
                'order_id' => $order->id,
                'delivery_time' => $deliveryTime,
                'status' => $statuses[array_rand($statuses)],
                'driver_name' => $drivers[array_rand($drivers)],
            ]);
        }
    }
}
