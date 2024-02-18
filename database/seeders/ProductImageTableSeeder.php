<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productIds = DB::table('products')->pluck('id')->toArray();
        $listImage = ['a', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'o', 's'];

        for ($i = 0; $i < 50; $i++) {
            $productId = $productIds[array_rand($productIds)];
            $image = 'imagesfp/product/' . $listImage[$i % 10] . '.jpg';

            ProductImage::create([
                'image' => $image,
                'product_id' => $productId,
            ]);
        }
    }
}