<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'Customer')->get();
        $menus = Menu::all();
        $packages = Package::all();

        if ($customers->isEmpty() || $menus->isEmpty() || $packages->isEmpty()) {
            return;
        }

        $eventNames = ['Pernikahan', 'Seminar', 'Ulang Tahun', 'Rapat Tahunan', 'Reuni Keluarga'];
        $locations = ['Gedung Serbaguna A', 'Hotel B', 'Rumah Kediaman C', 'Kantor Pusat D', 'Aula Sekolah E'];

        foreach ($customers as $index => $customer) {
            // Setiap customer akan dibuatkan minimal 1-2 order
            $orderCount = rand(1, 2);
            for ($o = 0; $o < $orderCount; $o++) {
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'order_date' => Carbon::now()->addDays(rand(1, 30)),
                    'total_amount' => 0, 
                    'status' => ['Pending', 'Paid', 'Cancelled'][array_rand(['Pending', 'Paid', 'Cancelled'])],
                ]);

                Event::create([
                    'order_id' => $order->id,
                    'event_name' => $eventNames[array_rand($eventNames)],
                    'event_date' => Carbon::now()->addDays(rand(10, 60)),
                    'location' => $locations[array_rand($locations)],
                    'num_guests' => rand(50, 300),
                ]);

                $totalAmount = 0;

                // Random package (1 package)
                if (rand(0, 1)) {
                    $package = $packages->random();
                    $qty = rand(1, 3);
                    $subtotal = $package->total_price * $qty;
                    OrderItem::create([
                        'order_id' => $order->id,
                        'package_id' => $package->id,
                        'quantity' => $qty,
                        'unit_price' => $package->total_price,
                        'subtotal' => $subtotal,
                    ]);
                    $totalAmount += $subtotal;
                }

                // Random menus (2-4 menus)
                for ($j = 0; $j < rand(2, 4); $j++) {
                    $menu = $menus->random();
                    $qty = rand(10, 50);
                    $subtotal = $menu->price * $qty;
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_id' => $menu->id,
                        'quantity' => $qty,
                        'unit_price' => $menu->price,
                        'subtotal' => $subtotal,
                    ]);
                    $totalAmount += $subtotal;
                }

                $order->update(['total_amount' => $totalAmount]);
            }
        }
    }
}
