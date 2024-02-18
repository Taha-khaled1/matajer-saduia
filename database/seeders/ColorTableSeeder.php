<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Color::create([
            'name_ar' => 'احمر',
            'name_en' => 'red',
            'color_code' => '#FF0000',

        ]);
        
        Color::create([
            'name_ar' => 'ذهبي',
            'name_en' => 'gold',
            'color_code' => '#ffc100',

        ]);
        
        Color::create([
            'name_ar' => 'اسود',
            'name_en' => 'black',
            'color_code' => '#000000',

        ]);
        
        Color::create([
            'name_ar' => 'ابيض',
            'name_en' => 'white',
            'color_code' => '#FFFFFF',

        ]);
        Color::create([
            'name_ar' => 'ازرق',
            'name_en' => 'blue',
            'color_code' => '#89CFF0',

        ]);
    }
}