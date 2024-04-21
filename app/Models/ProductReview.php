<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_reviews';  
      protected $guarded = [];
    use HasFactory;
public function product()
{
    return $this->belongsTo(Product::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}