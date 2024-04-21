<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    protected $primaryKey = 'id';
    public function ratingsGiven()
    {
        return $this->hasMany(UserReview::class, 'user_id');
    }

    public function ratingsReceived()
    {
        return $this->hasMany(UserReview::class, 'vendor_id');
    }
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function setting()
    {
        return $this->hasOne(Setting::class, 'user_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }
    public function marketers_reports()
    {
        return $this->hasMany(MarketersReports::class, 'user_id');
    }
    public function histories()
    {
        return $this->hasMany(History::class, 'user_id');
    }
    public function referredUsers()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }

    // The affiliate marketer who referred this user
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'user_id');
    }
    public function shippingCompanies()
    {
        return $this->hasMany(ShippingCompanies::class, 'user_id'); // 
    }
    public function user_address()
    {
        return $this->hasMany(UserAddress::class, 'user_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function mosaoqOrders()
    {
        return $this->hasMany(Order::class, 'mosaoq_id');
    }
    public function ordersShopes()
    {
        return $this->hasMany(Order::class, 'shope_id');
    }
}
