<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Ingredients;
use App\Models\Recipe;
use App\Models\RecipeDetails;
use App\Models\Storage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
  public function widget()
  {

    //INGREDIENTES BAJOS
    $ingredients = Ingredients::all();
    $total_count = [];
    $array = [];

    foreach ($ingredients as $key => $x) {
      $temp = Storage::where('ingredient_id', '=', $x->id)->sum('quantity');

      if ($temp <= ($x->quantity * 0.20)) {
        $total_count[] = $temp;
        $array[] = $x;

      }
    }

    $props = ["lowStock" => $array, "total_count" => $total_count];

    //APLICAR RECETA
    $props['recipes'] = Recipe::where('status', '!=', 0)->get();
    return Inertia::render('DashboardAdmin', $props);
  }

  public function use_in_storage(Request $request)
  {
    // print('hola');
    //DATA
    $data = $request->all();
    $recipe = Recipe::where('id', '=', $data['recipe_id'])->get('name');
    $details = RecipeDetails::where('recipe_id', '=', $data['recipe_id'])->get();
    $date = date_create();

    //DEFAULTS
    $store[] = [];
    $store['movement'] = 'salida';
    $store['from'] = 1;
    $store['session'] = 'W' . date_format($date, 'W') . '-' . date_format($date, 'Y');

    foreach ($details as $ing) {
      $store['quantity'] = $ing->quantity * $data['quantity'];
      $store['detail_id'] = $ing->id;
      $store['ingredient_id'] = $ing->ingredient_id;

      $store['description'] = $recipe[0]->name . ' - ' . $ing->section->name . ': ' . $ing->quantity . ' ' . $ing->ingredient->name;
      //total
      $store['total'] = Storage::where('ingredient_id', '=', $ing->ingredient_id)->sum('quantity') - ($ing->quantity * $data['quantity']);

      //SAVE
      Storage::create($store);
    }

    return;
  }
  public function save_sale(Request $request)
  {
    //DATA
    $date = date_create();
    $data = $request->all();
    $recipe = Recipe::where('id', '=', $data['recipe_id'])->get()->first();

    //DEFAULTS
    $balance[] = [];
    $balance['movement'] = 'entrada';
    $balance['session'] = 'W' . date_format($date, 'W') . '-' . date_format($date, 'Y');
    $balance['recipe_id'] = $data['recipe_id'];
    $balance['quantity'] = $data['quantity'];

    $balance['description'] = 'Venta: '.$data['quantity'].' '.$recipe['presentation'].' de '.$recipe['name'];
    $balance['balance'] = $recipe['unit_price'] * $data['quantity'];

    $latest = Balance::latest('created_at')->get()->first();
    $balance['current_balance'] = $latest->current_balance + $balance['balance'];
    
    Balance::create($balance);
  }
}
