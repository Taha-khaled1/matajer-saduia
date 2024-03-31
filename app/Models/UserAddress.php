<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    // public $timestamps = false;
    protected $guarded = [];
    protected $table = 'user_addresses';
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // 
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function scopeSingleAddressRes($query)
    {
        return $query; // ->select("id", "country", "address_1", "name", "email", "phone", "longitude", "latitudes", "location_id")
    }

    public function scopeAddressRes($query, $id)
    {
        return $query->where("user_id", $id); // ->select("id","country", "address_1", "name", "email", "phone", "longitude", "latitudes", "location_id")
    }
}
