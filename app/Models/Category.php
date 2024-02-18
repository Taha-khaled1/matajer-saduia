<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Category extends Model  
{    protected $fillable = [
        'name_en',
        'name_ar',
        'image',
        'status', 
        'arrange',
    ];
   
   
    protected $table = 'categories';
    use HasFactory;


    public function subCategories()
    {
        return $this->hasMany(SubCategory::class,'category_id');
    }
      public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }
  public function getImageUrl()
    {
        return Storage::disk('imagesfp')->url($this->image);
    }
}