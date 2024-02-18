<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'sizes';  
      protected $fillable = [
        'name_en',
        'name_ar',
        'id',
    ];
       public function attribute()
    {
        return $this->hasOne(Attribute::class,'size_id');
    }
}