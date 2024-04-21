<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackgeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::create([
            'name' => 'الباقه العاديه',
            'price' => 59,
            'duration_days' => 30,
            'commission_percentage' => 5.0,
            'subscription' => 'normal',
        ]);
        Package::create([
            'name' => 'الباقه الفضيه',
            'price' => 199,
            'duration_days' => 30,
            'commission_percentage' => 3.0,
            'subscription' => 'silver',

        ]);
        Package::create([
            'name' => 'الباقه الذهبيه',
            'price' => 499,
            'duration_days' => 30,
            'commission_percentage' => 1.0,
            'subscription' => 'golden',
        ]);
    }
}
