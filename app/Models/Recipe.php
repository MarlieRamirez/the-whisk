<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    protected $table = 'recipe';
    protected $fillable = ['name','quantity','presentation', 'unit_price', 'batch_cost','unit_cost','status'];
    public $timestamps = false;
    public function details(): HasMany{
        return $this->hasMany(RecipeDetails::class, 'recipe_id', 'id');
    }
    public function sector(){
        return $this->hasManyThrough(Sector::class, RecipeDetails::class, 'recipe_id','id', 'id', 'sector_id');
    }
    public function ingredients(){
        return $this->hasManyThrough(Ingredients::class, RecipeDetails::class, 'recipe_id','id', 'id', 'ingredient_id');
    }
}
