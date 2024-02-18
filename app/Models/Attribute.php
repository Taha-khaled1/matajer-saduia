<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $hidden = ['product_id','color_id','size_id'];
    protected $table = 'attributes';   protected $guarded = []; 
    public $timestamps = false;

    public function product()
   {
        return $this->belongsTo(Product::class, 'product_id');
   }
       public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'attribute_id');
    }
    public function color()
    {
        return $this->belongsTo(Color::class,'color_id');
    }
     public function size()
    {
        return $this->belongsTo(Size::class,'size_id');
    }
}