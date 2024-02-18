<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $primaryKey = 'id';


    protected $table = 'sub_categories';
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_ar',
        'image',
        'status',
        'id',// category id
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');// 
    }
    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class,'sub_category_id');
    }
}