<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Size::create([
            'name_ar' => 'اكس لارج',
            'name_en' => 'XL',
          
            
            
        ]);

        Size::create([
            'name_ar' => 'اكس ال',
            'name_en' => 'X',
          
            
            
        ]);
    

        Size::create([
            'name_ar' => 'لارج',
            'name_en' => 'S',
    
            
            
        ]);

        Size::create([
            'name_ar' => 'متوسط',
            'name_en' => 'M',
 
            
            
        ]);
        Size::create([
            'name_ar' => 'اكس اكس ال',
            'name_en' => 'XXL',
 
            
            
        ]);
    }
}