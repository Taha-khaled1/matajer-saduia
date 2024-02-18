<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Order 1
        Order::create([
            'status' => 'pending',
            'payment_status' => 'paid',
            'payment_method' => 'stripe',
            'currency' => 'aed',
            'cancelled' => false,
            'shipping' => 10.0,
            'tax' => 5.0,
            'discount' => 15.0,
            'subtotal' => 1500,
            'total' => 1500 + 10.0 + 5.0,
            'user_id' => 1,
            'shope_id' => 1,
            'user_address_id' => 1,
            'coupon_id' => null,
        ]);

        // Order 2
        Order::create([
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'stripe',
            'currency' => 'aed',
            'cancelled' => false,
            'shipping' => 8.0,
            'tax' => 4.0,
            'discount' => 30,
            'subtotal' => 1050,
            'total' => 1050 - 30 + 24,
            'user_id' => 2,
            'shope_id' => 1,
            'user_address_id' => 2,
            'coupon_id' => 1,
        ]);

        // Order 3
        Order::create([
            'status' => 'cancelled',
            'payment_status' => 'failed',
            'payment_method' => 'stripe',
            'currency' => 'aed',
            'cancelled' => true,
            'shipping' => 12.0,
            'tax' => 6.0,
            'discount' => 5,
            'subtotal' => 1170,
            'total' => 1170 - 5 + 30,
            'user_id' => 3,
            'shope_id' => 2,
            'user_address_id' => 3,
            'coupon_id' => null,
        ]);
    }
}
