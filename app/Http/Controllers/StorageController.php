<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Ingredients;
use App\Models\Storage;
use Date;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($updated = false)
    {        
        $storage = Storage::all();
        $props = ["list_of"=>$storage, "title"=>"Inventario", "href"=>"storage"];
        
        if($updated){
            $props['updated'] = $updated;
            
        }

        return Inertia::render('tables/StorageTable', $props);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function new()
    {
        $ingredients = Ingredients::all();
        return Inertia::render('form/Storage', ["in"=>true,"ingredients"=>$ingredients]);
    }

    public function minus()
    {
        $ingredients = Ingredients::all();
        return Inertia::render('form/Storage', ["ingredients"=>$ingredients]);
    }


    public function store(Request $request)
    {
        //Reocurring variables
        $date = date_create();
        $session = 'W'.date_format($date, 'W').'-'.date_format($date, 'Y');
        $quantity =  $request->get('quantity');

        //Ingredient
        $ingredient = Ingredients::find($request['ingredient_id']);

        //Predef attributes
        $request['description'] = $request->get('movement'). ' de '. $quantity.' '. $ingredient->name;
        $request['total'] = Storage::where('ingredient_id', '=',$ingredient->id)->sum('total') + ($quantity * $ingredient->quantity);
        $request['session'] = $session;

        //Save in case of changing price
        $ingredient->price = $request['price'];
        $ingredient->save();

        //Inventario
        Storage::create($request->all());
        //Balance - Spent ... in ....
        
        $balance[] = [];

        //Create Balance object
        if($request['movement'] == 'Entrada'){
            $balance['movement'] = 'Salida';
            $balance['description'] = 'Compra de '. $quantity.' '. $ingredient->name;
            $balance['quantity'] = $request->get('quantity');
            $balance['ingrediente_id'] = $request['ingredient_id'];
            // price * quantity
            $balance['balance'] = -($ingredient->price * $quantity);
            $balance['current_balance'] = Balance::sum('balance') + $balance['balance'];
            $balance['session'] = $session;
            Balance::create($balance);
        }

        return redirect()->route('storage.index', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
