<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountCouponSeeder extends Seeder
{
     public function run()
    {
        // Create seed data
        $coupons = [
            [
                'code' => 'SUMMER2023',
                'discount_amount' => 10.00,
                // 'category_id' => null,
                // 'sub_category_id' => 1,
                // 'apply_to_all' => false,
                'start_date' => '2023-07-01',
                'end_date' => '2023-07-31',
                'user_id' => 1,
            ],
            [
                'code' => 'SALE50',
                'discount_amount' => 50.00,
                // 'category_id' => 1,
                // 'sub_category_id' => null,
                // 'apply_to_all' => false,
                'start_date' => '2023-07-01',
                'end_date' => '2023-08-31',
                'user_id' => 1,
            ],
            [
                'code' => 'XA50ER',
                'discount_amount' => 35.00,
                // 'category_id' => 1,
                // 'sub_category_id' => 1,
                // 'apply_to_all' => false,
                'start_date' => '2023-07-01',
                'end_date' => '2023-08-31',
                'user_id' => 1,
            ],   [
                'code' => 'LOT80ZC',
                'discount_amount' => 35.00,
                // 'category_id' => null,
                // 'sub_category_id' => null,
                // 'apply_to_all' => true,
                'start_date' => '2023-07-01',
                'end_date' => '2023-08-31',
                'user_id' => 1,
            ],
            [
                'code' => 'LO9RZC',
                'discount_amount' => 35.00,
                // 'category_id' => null,
                // 'sub_category_id' => null,
                // 'apply_to_all' => true,
                'start_date' =>'2023-07-01',
                'end_date' => '2023-07-10',
                'user_id' => 1,
            ],
            [
                'code' => 'TOP555R',
                'discount_amount' => 35.00,
                // 'category_id' => null,
                // 'sub_category_id' => null,
                // 'apply_to_all' => true,
                'start_date' =>'2023-08-01',
                'end_date' => '2023-09-10',
                'user_id' => 1,
            ],
        ];

        
       Coupon::insert($coupons);
    }
}