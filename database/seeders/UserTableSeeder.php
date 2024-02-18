<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $userData = [
            [
                'name' => 'taha',
                'type' => 'admin',
                'status' => 1,

                'isfirst' => 1,
                'email' => 'tth31770@gmail.com',
                'created_at' => now(),
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'mohamed',
                'type' => 'vendor',
                'status' => 1,
                'isfirst' => 1,
                'email' => 'vendor@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ahmed',
                'type' => 'user',
                'status' => 1,
                'isfirst' => 1,
                'email_verified_at' => now(),
                'email' => 'user1@gmail.com',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'ahmed Ragaa',
                'type' => 'user',
                'status' => 1,
                'isfirst' => 1,
                'email_verified_at' => now(),
                'email' => 'ahmedragaa07@gmail.com',
                'password' => bcrypt('Ahmed12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'name' => 'yousef',
                'type' => 'user',
                'status' => 1,
                'isfirst' => 1,
                'email' => 'user2@gmail.com',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'magedy',
                'type' => 'user',
                'status' => 1,
                'isfirst' => 1,
                'email' => 'user3@gmail.com',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $userPermission = [
            'admin',
            'vendor',
            'user',
        ];
        $PermissionAdmin = [
            'الصفحه الرئيسيه',
            'الصفحه الرئيسيه للتاجر',
            'عام',
            'الاقسام',
            'جميع الاقسام', 'البنرات الإعلانية',
            'اضافة قسم',
            'تعديل قسم',
            'حذف قسم',
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
            'الالوان و الاحجام',
            'بوبات الدفع',
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
            'اعدادت الهدايا',
            'الطلبيات',
            'جميع الطلبيات',
            'عرض الطلبيه',
            'حذف الطلبيه',
            'طباعة الطلبيه',
            'شكاوي العملاء',
            'المستخدمين',
            'رؤية المستخدمين',
            'صلاحيات المستخدمين',
            'الدول و الضرائب',
            // 'رؤية الدول',
            // 'رؤية المدن',
            // 'الابلاغات',
            'التقارير و الاستعلامات',
            'الاعدادات',
            'اعدادت الصفحات',
            'الاعدادت الرئيسيه',
            'الاعدادت العامه',
            'الصفحه الرئيسيه للبائع',
            'المتتجات الخاصه',            'الطلبيات الخاصه بك',



        ];

        $Permissionvendor = [
            'الطلبيات',
            'الطلبيات الخاصه بك',
            'الصفحه الرئيسيه للبائع',
            'الصفحه الرئيسيه للتاجر',
            'المتتجات الخاصه',
            'الاعدادات',
            'الاعدادت العامه',
            'الاعدادت الرئيسيه',
            'المنتجات',
            'اضافة منتج',
            'تعديل منتج',
            'حذف منتج',
            'تسوق',
        ];


        $roleList = [];
        foreach ($userPermission as $permissionName) {
            $role = Role::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);

            if ($role->name == 'admin') {
                $role->syncPermissions($PermissionAdmin);
            } else {
                $role->syncPermissions($Permissionvendor);
            }

            $roleList[] = $role->id;
        }

        foreach ($userData as $data) {
            $user = User::create($data);
            if ($user->id == 1) {
                $user->assignRole([$roleList[0]]);
            } elseif ($user->id == 2) {
                $user->assignRole([$roleList[1]]);
            } else {
                $user->assignRole([$roleList[2]]);
            }
        }
    }
}
