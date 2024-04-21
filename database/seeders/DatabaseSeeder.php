<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            UserTableSeeder::class,
            UserAddressTableSeeder::class,
            CatogeryTableSeeder::class,
            SubCatogeryTableSeeder::class,
            PackgeTableSeeder::class,
            SizeTableSeeder::class,
            ColorTableSeeder::class,
            ProductTableSeeder::class,
            ProductImageTableSeeder::class,
            SettingsTableSeeder::class,
            DiscountCouponSeeder::class,
            SettingWebTableSeeder::class,
            MistanceModeTableSeeder::class,
            OrderTableSeeder::class,
            OrderItemsTableSeeder::class,
            CountryTableSeeder::class,
            GiftTableSeeder::class,
            AttributeTableSeeder::class,
            BannerTableSeeder::class,
            PaymentGetwayTableSeeder::class,
        ]);
    }
}
