<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'discount_amount',
        'section_id',
        'sub_section_id',
        'apply_to_all',
        'start_date',
        'end_date',
        'user_id',
    ];

    // Relationship with Section
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    // Relationship with SubSection
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
      public function orders()
    {
        return $this->hasMany(Order::class);
    }  
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}