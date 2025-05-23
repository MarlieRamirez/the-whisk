<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $table = 'storage';
    protected $fillable = ['ingredient_id', 'detail_id', 'movement', 'description', 'quantity', 'from', 'total', 'session'];
}
