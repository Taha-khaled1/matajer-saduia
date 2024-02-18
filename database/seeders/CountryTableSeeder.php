<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Country::create([
                'name' => 'الإمارات العربية المتحدة',
                'name_en'=>'United Arab Emirates',
                'country_tax' => 10,
                'latitude'=>24.00,           
                'longitude'=>54.00,
            ]);

             Country::create([
                'name' => 'مصر',
                'name_en'=>'Egypt',
                'country_tax' => 20,
                'latitude'=>27.00,           
                'longitude'=>30.00,
            ]);
            
           Country::create([
                'name' => 'المملكة العربية السعودية',
                'name_en'=>'Saudi Arabia',
                'country_tax' => 30,
                'latitude'=>25.00,           
                'longitude'=>45.00,
            ]);       
    }
}