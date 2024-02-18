<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $table = 'colors';
     protected $fillable = [
        'name_en',
        'name_ar',
        'color_code',
        'id',
    ];
   public function attribute()
    {
        return $this->hasOne(Attribute::class,'color_id');
    }
}