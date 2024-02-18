<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'quantity', 'product_id', "attribute_id"]; //user_id // product_id
    protected $hidden = ['weight'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }


    public function scopeCartItemsData($query, $userId)
    {
        return $query->where('cart_items.user_id', $userId)
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->select(
                'cart_items.id',
                'cart_items.product_id',
                'cart_items.quantity',
                'cart_items.attribute_id',
                DB::raw("products.name_" . app()->getLocale() . " AS name"),
                DB::raw("products.description_" . app()->getLocale() . " AS description"),
                'products.image',
                'products.price',
                'products.discount',
                'products.discount_start',
                'products.discount_end',
                'products.weight',
                'products.shipping_fee',
            )->with("attribute.size", "attribute.color");
    }
}
