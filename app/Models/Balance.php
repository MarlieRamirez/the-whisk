<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balance';
    protected $fillable = ['movement', 'recipe_id','quantity', 'ingrediente_id', 'description', 'balance', 'current_balance', 'session' ];
}
