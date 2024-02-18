<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gifts = [
        [
            'first_order' => 'هدية اول طلب',
            'first_order_price' => 10,
            'buying_specified_value' => 'هدية عند الطلب بقيمه محدده',
            'buying_specified_value_price' => 20,
            'specified_value_price' => 500,
            'discount_after_first_month' => 'الخصم بعد تجاوز الشهر علي السله',
            'discount_after_first_month_price' => 5,
        ],
        // Add more gift records as needed
    ];

    DB::table('gifts')->insert($gifts);
    }
}