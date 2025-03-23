<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Ingredients;
use App\Models\Storage;
use Date;
use DB;
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
        $props = ["list_of" => $storage, "title" => "Inventario", "href" => "storage"];

        if ($updated) {
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
        return Inertia::render('form/Storage', ["in" => true, "ingredients" => $ingredients]);
    }

    public function minus()
    {
        config()->set('database.connections.mysql.strict', false);
        DB::reconnect();
        $ids = Storage::where('ingredient_id', '!=', null)
            ->groupBy('ingredient_id')
            ->get(['ingredient_id']);
        
        $valid = [];
        
        //FILTER IF TOTAL STORAGE
        foreach($ids as $x){
            $item = Storage::latest('created_at')->where('ingredient_id', '=',$x['ingredient_id'])->get();
            
            if($item[0]->total > 0){
                // print($item);
                $valid[] =$item[0]['ingredient_id'];
            }
        }
        
        
        $all = Ingredients::whereIn('id', $valid)->get();
        return Inertia::render('form/Storage', ["ingredients" => $all]);
    }


    public function store(Request $request)
    {
        //Ingredient
        $ingredient = Ingredients::find($request['ingredient_id']);

        //Reocurring variables
        $date = date_create();
        $session = 'W' . date_format($date, 'W') . '-' . date_format($date, 'Y');

        $quantity_request = $request->get('quantity');
        $quantity = $request->get('quantity') * $ingredient->quantity;

        //Setup

        $request['session'] = $session;

        //Balance - Spent ... in ....
        $balance[] = [];

        //If inside addition
        if ($request['movement'] == 'Entrada') {
            //config Storage addition
            $request['description'] = $request->get('movement') . ' de ' . $quantity . ' ' . $ingredient->name;
            $request['quantity'] = $quantity;
            $request['total'] = Storage::where('ingredient_id', '=', $ingredient->id)->sum('quantity') + $request['quantity'];

            //Set-up balance object
            $balance['movement'] = 'Salida';
            $balance['description'] = 'Compra de ' . $quantity . ' ' . $ingredient->name;
            $balance['quantity'] = $quantity_request;
            $balance['ingrediente_id'] = $request['ingredient_id'];

            // price * quantity
            $balance['balance'] = -($ingredient->price * $quantity);
            $balance['current_balance'] = Balance::sum('balance') + $balance['balance'];
            $balance['session'] = $session;
            Balance::create($balance);
        } else {
            $request['total'] = Storage::where('ingredient_id', '=', $ingredient->id)->sum('quantity') - $quantity_request;
            $request['quantity'] = $quantity_request;
            $request['description'] = 'Salida: ' . $request['description'];
        }

        //Inventario
        Storage::create($request->all());

        //Save in case of changing price
        $ingredient->price = $request['price'];
        $ingredient->save();
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
