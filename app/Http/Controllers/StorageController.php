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
        $ingredients = Ingredients::all();
        
        $total_count = [];

        foreach($ingredients as $x){
            $temp = Storage::where('ingredient_id', '=',$x->id)->sum('quantity');
            $total_count[] = $temp;
        }

        $props = ["list_of" => $ingredients,"list_totals"=>$total_count, "title" => "Inventario", "href" => "storage"];

        if ($updated) {
            $props['updated'] = $updated;

        }

        return Inertia::render('tables/StorageTable', $props);
    }

    public function movements(string $id, $updated=false) {
        $storage = Storage::where('ingredient_id', '=', $id)->get();

        $props = ["list_of" => $storage, "title" => "Inventario", "href" => "storage","id"=>$id];
        
        if ($updated) {
            $props['updated'] = $updated;
        }
        
        return Inertia::render('tables/StorageIngredientsTable', $props);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function new($id = 0)
    {
        $ingredients = Ingredients::all();
        $props = ["in" => true, "ingredients" => $ingredients];

        if($id!=0){
            $props['id'] = $id;
        }

        return Inertia::render('form/Storage', $props);
    }

    public function minus($id=0)
    {
        config()->set('database.connections.mysql.strict', false);
        DB::reconnect();
        $ids = Storage::where('ingredient_id', '!=', null)
            ->groupBy('ingredient_id')
            ->get(['ingredient_id']);
        
        config()->set('database.connections.mysql.strict', true);
        DB::reconnect();
        

        $valid = [];
        $totals = [];
        //FILTER IF TOTAL STORAGE
        foreach($ids as $x){
            $item = Storage::latest('created_at')->where('ingredient_id', '=',$x['ingredient_id'])->get();
            
            if($item[0]->total > 0){
                // print($item);
                $valid[] = $item[0]['ingredient_id'];
                $totals[] = $item[0]['total'];
            }
        }
        
        $all = Ingredients::whereIn('id', $valid)->get();

        $props =["ingredients" => $all, "totals"=>$totals];

        if($id!=0){
            $props['id'] = $id;
        }

        return Inertia::render('form/Storage',$props );
    }


    public function store(Request $request)
    {
        //Ingredient
        $ingredient = Ingredients::find($request['ingredient_id']);
        $ingredient->price = $request['price'];
        //Save in case of changing price
        $ingredient->save();

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
            $balance['balance'] = -($ingredient->price * $quantity_request);
            $balance['current_balance'] = Balance::sum('balance') + $balance['balance'];
            $balance['session'] = $session;

            $storage = Storage::create($request->all());
            $balance['storage_id'] = $storage->id;
            
            Balance::create($balance);
        } else {
            $request['total'] = Storage::where('ingredient_id', '=', $ingredient->id)->sum('quantity') - $quantity_request;
            $request['quantity'] = -$quantity_request;
            $request['description'] = 'Salida: ' . $request['description'];

            //Storage
            Storage::create($request->all());
        }

        
        
        if($request['to_movement']){
            return redirect()->route('storage.product.index', [$ingredient->id, true]);    
        }

        return redirect()->route('storage.index', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $storage = Storage::find($id);
        $ingredient_id = $storage->ingredient_id;

        $balance = Balance::where('storage_id','=', $id)->first();

        //if removing 'Entrada' remove record in balance
        if($storage->movement == 'entrada'){
            //get rid of constraint
            $balance->storage_id = null;
            $balance->save();

            //revert with new
            $balance->id = null;

            //set current
            $balance->quantity = 0;
            $balance->balance = -$balance->balance;
            $balance->current_balance = Balance::sum('balance') + $balance->balance;

            //save as new
            $balance->movement = 'entrada';
            $balance->description = 'Revertir: '.$balance->description;
            
            print($balance);
            Balance::create($balance->toArray());
        }
        $storage->delete();
        return redirect()->route('storage.product.index', [$ingredient_id, true]);    
    }
}
