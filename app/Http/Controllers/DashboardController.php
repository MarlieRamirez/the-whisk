<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use App\Models\Recipe;
use App\Models\Storage;
use Inertia\Inertia;

class DashboardController extends Controller
{
  public function widget()
  {
    
    //INGREDIENTES BAJOS
    $ingredients = Ingredients::all();
    $total_count = [];
    $array = [];

    foreach ($ingredients as $key=>$x) {
      $temp = Storage::where('ingredient_id', '=', $x->id)->sum('quantity');
      
      if($temp <= ($x->quantity*0.20)){
        $total_count[] = $temp;
        $array[] = $x;

      }
    }

    $props = ["lowStock" => $array, "total_count" => $total_count];
    
    //APLICAR RECETA
    $props['recipes'] = Recipe::all();
    return Inertia::render('DashboardAdmin', $props);
  }
}
