<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCatogeryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubCategory::create([
            'name_ar' => 'فساتين',
            'name_en' => 'Dresses',
            'image' => 'imagesfp/subcategory/z.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'أحذية رياضية',
            'name_en' => 'Sports Shoes',
            'image' => 'imagesfp/subcategory/zz.jpg',
            'category_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'مجوهرات',
            'name_en' => 'Jewelry',
            'image' => 'imagesfp/subcategory/xx.jpg',
            'category_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'أجهزة محمولة',
            'name_en' => 'Mobile Devices',
            'image' => 'imagesfp/subcategory/x.jpg',
            'category_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'أرائك',
            'name_en' => 'Sofas',
            'image' => 'imagesfp/subcategory/y.jpg',
            'category_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'بناطيل',
            'name_en' => 'Pants',
            'image' => 'imagesfp/subcategory/c.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'نظارات شمسية',
            'name_en' => 'Sunglasses',
            'image' => 'imagesfp/subcategory/v.jpg',
            'category_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'أجهزة الكمبيوتر',
            'name_en' => 'Computers',
            'image' => 'imagesfp/subcategory/b.jpg',
            'category_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'كراسي',
            'name_en' => 'Chairs',
            'image' => 'imagesfp/subcategory/n.jpg',
            'category_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'تنانير',
            'name_en' => 'Skirts',
            'image' => 'imagesfp/subcategory/m.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);













        SubCategory::create([
            'name_ar' => 'قمصان',
            'name_en' => 'Shirts',
            'image' => 'imagesfp/subcategory/z.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'فساتين',
            'name_en' => 'Dresses',
            'image' => 'imagesfp/subcategory/x.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'بناطيل',
            'name_en' => 'Pants',
            'image' => 'imagesfp/subcategory/xx.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'أحذية',
            'name_en' => 'Shoes',
            'image' => 'imagesfp/subcategory/n.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'إكسسوارات',
            'name_en' => 'Accessories',
            'image' => 'imagesfp/subcategory/b.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'مستحضرات التجميل',
            'name_en' => 'Cosmetics',
            'image' => 'imagesfp/subcategory/v.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'الأثاث الداخلي',
            'name_en' => 'Indoor Furniture',
            'image' => 'imagesfp/subcategory/y.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'الألعاب الخارجية',
            'name_en' => 'Outdoor Toys',
            'image' => 'imagesfp/subcategory/xx.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'مستلزمات الرياضة',
            'name_en' => 'Sports Accessories',
            'image' => 'imagesfp/subcategory/y.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'أدوات المطبخ',
            'name_en' => 'Kitchen Tools',
            'image' => 'imagesfp/subcategory/c.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'name_ar' => 'منتجات للحيوانات الأليفة',
            'name_en' => 'Pet Products',
            'image' => 'imagesfp/subcategory/v.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}