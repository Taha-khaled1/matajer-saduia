<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            OrderItem::create([
            'product_id' => 1,
            'order_id' => 1,
            'quantity' => 2,
        ]);

        // Order Item 2 (Belongs to Order 1)
        OrderItem::create([
            'product_id' => 3,
            'order_id' => 1,
            'quantity' => 1,
        ]);

        // Order Item 3 (Belongs to Order 2)
        OrderItem::create([
            'product_id' => 2,
            'order_id' => 2,
            'quantity' => 3,
        ]);

        // Order Item 4 (Belongs to Order 3)
        OrderItem::create([
            'product_id' => 4,
            'order_id' => 3,
            'quantity' => 1,
        ]);

        // Order Item 5 (Belongs to Order 3)
        OrderItem::create([
            'product_id' => 5,
            'order_id' => 3,
            'quantity' => 2,
        ]);
    }
}