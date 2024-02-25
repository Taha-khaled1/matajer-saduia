<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{

    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $appends = ['final_price'];
    // protected $hidden = ['discount_start','discount_end'];
    protected $hidden = ['attribute'];
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }
    public function attribute()
    {
        return $this->hasMany(Attribute::class, 'product_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function advertisement()
    {
        return $this->hasMany(Advertisement::class, 'product_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }





    // Accessor to calculate the final price after applying the discount
    public function getFinalPriceAttribute()
    {
        // Get the current time
        $currentTime = Carbon::now();

        // Check if the product has a valid discount (discount is not null and within the valid time range)
        if (
            $this->discount !== null && $this->discount >= 0 &&
            $this->discount_start !== null && $this->discount_end !== null
        ) {

            $discountStartTime = Carbon::parse($this->discount_start);
            $discountEndTime = Carbon::parse($this->discount_end);

            // Check if the current time is within the discount start and end time
            if ($currentTime->isBetween($discountStartTime, $discountEndTime)) {

                // Calculate the final price after applying the discount
                $finalPrice = $this->price - $this->discount;
                return $finalPrice;
            }
        }

        // If there's no valid discount or the current time is outside the discount period, return the original price
        return $this->price;
    }


    public function scopeActiveAndSorted($query)
    {
        return $query->where('status', 1)->where('is_gift', 0)
            ->orderBy('arrange')
            ->orderByDesc('created_at')
            ->select('id', DB::raw("name_" . app()->getLocale() . " AS name"), DB::raw("name_" . ReverseLanguage(app()->getLocale()) . " AS favorite_name"), 'price', 'image', 'discount_start', 'discount_end', 'discount', "sub_category_id");
    }
    public function scopeActiveAndSortedGift($query)
    {
        return $query->where('status', 1)->where('is_gift', 1)
            ->orderBy('arrange')
            ->orderByDesc('created_at')
            ->select('id', DB::raw("name_" . app()->getLocale() . " AS name"), DB::raw("name_" . ReverseLanguage(app()->getLocale()) . " AS favorite_name"), 'price', 'image', 'discount_start', 'discount_end', 'discount', "sub_category_id");
    }
    public function scopeActiveAndSortedHotitem($query)
    {
        return $query->where('status', 1)
            ->orderBy('views')
            ->orderByDesc('created_at')
            ->select('id', DB::raw("name_" . app()->getLocale() . " AS name"), DB::raw("name_" . ReverseLanguage(app()->getLocale()) . " AS favorite_name"), 'price', 'image', 'discount_start', 'discount_end', 'discount');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeProductById($query)
    {
        return $query->with([
            'images',
            'attribute',
            'user' => function ($query) {
                $query->select('id', 'name', 'email');
            },
            'user.setting' => function ($query) {
                $query->select('user_id', 'logo');
            }
        ])
            ->select('id', 'name_' . app()->getLocale() . ' AS name', DB::raw("name_" . ReverseLanguage(app()->getLocale()) . " AS favorite_name"), 'description_measurement_guide', 'measurement_guide', 'price', 'type_attribute', 'user_id', 'image', 'discount_start', 'discount_end', 'discount', 'description_' . app()->getLocale() . ' AS description', 'quantity', 'sub_category_id');
    }


    public function scopeActiveAndSortedForSearch($query, $keyword)
    {
        return $query->where('status', 1)
            ->where(function ($query) use ($keyword) {
                $query->where('name_en', 'LIKE', "%{$keyword}%")
                    ->orWhere('name_ar', 'LIKE', "%{$keyword}%")->orWhere('sku', $keyword);
            })
            ->orderByDesc('created_at')
            ->select('id', DB::raw("name_" . app()->getLocale() . " AS name"), DB::raw("name_" . ReverseLanguage(app()->getLocale()) . " AS favorite_name"), 'price', 'image', 'discount_start', 'discount_end', 'discount');
    }


    public function scopeActiveAndSortedForSearchById($query, $keyword)
    {
        return $query->where('status', 1)
            ->where(function ($query) use ($keyword) {
                $query->where('sku', $keyword);
            })
            ->orderByDesc('created_at')
            ->select('id', DB::raw("name_" . app()->getLocale() . " AS name"), DB::raw("name_" . ReverseLanguage(app()->getLocale()) . " AS favorite_name"), 'price', 'image', 'discount_start', 'discount_end', 'discount');
    }
}
// favoritename 