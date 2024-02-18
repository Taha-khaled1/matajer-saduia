<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatogeryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name_ar' => 'ملابس',
            'name_en' => 'Clothing',
            'image' => 'imagesfp/category/q.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'name_ar' => 'أحذية',
            'name_en' => 'Shoes',
            'image' => 'imagesfp/category/w.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'name_ar' => 'إكسسوارات',
            'name_en' => 'Accessories',
            'image' => 'imagesfp/category/e.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'name_ar' => 'إلكترونيات',
            'name_en' => 'Electronics',
            'image' => 'imagesfp/category/r.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'name_ar' => 'أثاث',
            'name_en' => 'Furniture',
            'image' => 'imagesfp/category/t.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);



        Category::create([
            'name_ar' => 'الرياضة واللياقة البدنية',
            'name_en' => 'Sports and Fitness',
            'image' => 'imagesfp/category/q.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'name_ar' => 'الأطعمة والمشروبات',
            'name_en' => 'Food and Beverages',
            'image' => 'imagesfp/category/r.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'name_ar' => 'المنتجات المنزلية',
            'name_en' => 'Home Products',
            'image' => 'imagesfp/category/t.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'name_ar' => 'السفر والسياحة',
            'name_en' => 'Travel and Tourism',
            'image' => 'imagesfp/category/e.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'name_ar' => 'الأدوات والمعدات',
            'name_en' => 'Tools and Equipment',
            'image' => 'imagesfp/category/q.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'name_ar' => 'الطبخ والمأكولات',
            'name_en' => 'Cooking and Dining',
            'image' => 'imagesfp/category/w.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'name_ar' => 'الحيوانات الأليفة',
            'name_en' => 'Pets',
            'image' => 'imagesfp/category/e.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}