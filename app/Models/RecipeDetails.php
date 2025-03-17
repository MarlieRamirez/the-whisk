<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RecipeDetails extends Model
{
    protected $table = 'recipe_details';
    protected $fillable = ['sector_id','recipe_id','ingredient_id', 'quantity', 'presentation','cost'];
    public $timestamps = false;

    public function section():HasOne{
        return $this->hasOne(Sector::class, 'id', 'sector_id');
    }
    public function ingredient():HasOne{
        return $this->hasOne(Ingredients::class, 'id', 'ingredient_id');
    }

}
