<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           $banners = [
            [
                'image' => 'imagesfp/banner/banner1.jpg',
                'arrange' => 1,
                'name' => 'Banner 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' =>'imagesfp/banner/banner2.jpg',
                'arrange' => 2,
                'name' => 'Banner 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'imagesfp/banner/banner3.jpg',
                'arrange' => 3,
                'name' => 'Banner 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert the data into the table
        DB::table('banners')->insert($banners);
    }
}