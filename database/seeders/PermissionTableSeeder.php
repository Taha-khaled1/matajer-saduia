<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permissions
        $permissions = [
            'الصفحه الرئيسيه',
            'الصفحه الرئيسيه للتاجر',
            'عام',
            'الاقسام',
            'جميع الاقسام',
            'اضافة قسم',
            'تعديل قسم',
            'حذف قسم',
            'الطلبيات الخاصه بك',
            'الاقسام الفرعيه',
            'جميع الاقسام الفرعيه',
            'اضافة الاقسام الفرعيه',
            'حذف الاقسام الفرعيه',
            'تعديل الاقسام الفرعيه',
            'تسوق',
            'المنتجات',
            'جميع المنتجات',
            'المنتجات الغير مفعله',
            'اضافة منتج',
            'تعديل منتج',
            'حذف منتج',
            'حالة منتج',
            'نسخ المنتج',
            'اعدادت الهدايا',
            'الالوان و الاحجام',
            'الالوان',
            'اضافة لون',
            'تعديل لون',
            'حذف لون',
            'الاحجام',
            'اضافة حجم',
            'تعديل حجم',
            'حذف حجم',
            'القسائم',
            'جميع القسائم',
            'اضافة قسيمه',
            'تعديل قسيمه',
            'حذف قسيمه',
            'الطلبيات',
            'جميع الطلبيات',
            'عرض الطلبيه',
            'حذف الطلبيه',
            'طباعة الطلبيه',
            'البنرات الإعلانية',
            'بوبات الدفع',
            'المستخدمين',
            'رؤية المستخدمين',
            'صلاحيات المستخدمين',
            'الدول و الضرائب',
            'التقارير و الاستعلامات',
            'الاعدادات',
            'اعدادت الصفحات',
            'الاعدادت الرئيسيه',
            'الاعدادت العامه',
            'الصفحه الرئيسيه للبائع',
            'المتتجات الخاصه',
            'شكاوي العملاء',
            'الاداره الماليه', 'الارصده'

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
