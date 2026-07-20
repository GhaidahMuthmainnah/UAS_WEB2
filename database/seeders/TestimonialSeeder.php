<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'Customer')->get();
        if ($customers->isEmpty()) {
            return;
        }

        $reviews = [
            "Masakannya sangat lezat! Tamu pernikahan saya semuanya puas dengan porsi yang melimpah dan rasa bumbu yang pas.",
            "Pelayanannya tepat waktu, armada logistiknya juga profesional. Sangat merekomendasikan katering ini untuk acara seminar.",
            "Pilihan menunya sangat variatif. Harga paketnya sangat terjangkau dengan kualitas makanan kelas hotel bintang lima.",
            "Semua staff sangat ramah ketika kami berkonsultasi mengenai menu. Makanannya juga disajikan dalam kondisi hangat.",
            "Overall memuaskan! Hanya saja variasi menu dessert mungkin bisa ditambah ke depannya. Tapi kualitas rasanya luar biasa!",
        ];

        foreach ($reviews as $review) {
            Testimonial::create([
                'customer_id' => $customers->random()->id,
                'rating' => 5,
                'review' => $review,
                'is_published' => true, // Dipublish agar terlihat di demo
            ]);
        }
    }
}
