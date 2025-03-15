<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Sector extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['name'];
    public $timestamps = false;
}
