<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;

    protected $table = 'gifts';

    protected $fillable = [
        'first_order',
        'first_order_price',
        'buying_specified_value',
        'buying_specified_value_price',
        'discount_after_first_month',
        'discount_after_first_month_price',
    ];
    public $timestamps = false;
}