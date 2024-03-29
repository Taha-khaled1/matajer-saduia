<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    //    protected $fillable = ['user_id', 'total_amount', 'is_paid'];
    protected $table = 'orders';
    protected $guarded = [];
    public function marketersReport()
    {
        return $this->hasOne(MarketersReports::class);
    }
    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItem::class, 'product_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function mosaoqUser()
    {
        return $this->belongsTo(User::class, 'mosaoq_id');
    }
    public function userShopes()
    {
        return $this->belongsTo(User::class, 'shope_id');
    }
    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
