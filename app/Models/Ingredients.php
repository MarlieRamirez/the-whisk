<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ingredients extends Model
{
    protected $table = 'ingredients';
    protected $fillable = ['category_id','brand_id','unit', 'quantity', 'price','name'];
    public $timestamps = false;

    public function category(): HasOne{
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function brand(): HasOne{
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
}
