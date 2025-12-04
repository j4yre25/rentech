<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::create([
            'order_number' => '12345A',
            'order_date' => now(),
            'customer_name' => 'John Doe',
            'payment_status' => 'Paid',
            'order_status' => 'Ready',
            'total' => 99.99,
        ]);
    }
}