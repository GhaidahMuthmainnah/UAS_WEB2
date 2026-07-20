<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Ghaidah',
                'email' => 'gaidah@gmail.com',
                'role' => 'Superadmin',
                'phone' => '0811111111',
                'address' => 'Jl. Superadmin No. 1',
            ],
            [
                'name' => 'Pemilik Catering',
                'email' => 'admin@gmail.com',
                'role' => 'Admin',
                'phone' => '0822222222',
                'address' => 'Jl. Admin No. 2',
            ],
            [
                'name' => 'Budi Staff',
                'email' => 'staff1@gmail.com',
                'role' => 'Staff',
                'phone' => '0833333333',
                'address' => 'Jl. Staff No. 3',
            ],
            [
                'name' => 'Siti Staff',
                'email' => 'staff2@gmail.com',
                'role' => 'Staff',
                'phone' => '0844444444',
                'address' => 'Jl. Staff No. 4',
            ],
            [
                'name' => 'Pelanggan Satu',
                'email' => 'customer1@gmail.com',
                'role' => 'Customer',
                'phone' => '0855555555',
                'address' => 'Jl. Customer No. 5',
            ],
            [
                'name' => 'Pelanggan Dua',
                'email' => 'customer2@gmail.com',
                'role' => 'Customer',
                'phone' => '0866666666',
                'address' => 'Jl. Customer No. 6',
            ],
            [
                'name' => 'Pelanggan Tiga',
                'email' => 'customer3@gmail.com',
                'role' => 'Customer',
                'phone' => '0877777777',
                'address' => 'Jl. Customer No. 7',
            ],
        ];

        foreach ($users as $user) {
            if (User::where('email', $user['email'])->exists()) {
                continue;
            }

            User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'phone' => $user['phone'],
                'address' => $user['address'],
            ]);
        }
    }
}
