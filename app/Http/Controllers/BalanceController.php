<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Ingredients;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($updated=false)
    {
        $balance = Balance::orderBy('id', 'DESC')->get();
        
        $props = ["list_of" => $balance, "title" => "Saldo", "href" => "balance"];

        if ($updated) {
            $props['updated'] = $updated;

        }
        
        return Inertia::render('tables/BalanceTable', $props);
    }

    public function add()
    {
        $ingredients = Recipe::where('status','=', 1)->get();
        $props = ["in" => true, "recipe" => $ingredients];

        return Inertia::render('form/Balance', $props);
    }
    public function minus()
    {
        $props = ["recipe" => []];
        return Inertia::render('form/Balance', $props);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date = date_create();
        $request['session'] = 'W' . date_format($date, 'W') . '-' . date_format($date, 'Y');
        
        if($request['movement'] == 'Entrada'){
            $recipe = Recipe::find($request['recipe_id']);
            $request['description'] = 'Venta: '. $request['quantity']. ' '. $recipe->presentation. ' de '.$recipe->name;
        }else{
            $request['description'] = 'Pago: '. $request['description'];
        }

        
        $request['balance'] = $request['current_balance'];
        $latest = Balance::latest('created_at')->first();
        $request['current_balance'] = $latest['current_balance'] + $request['current_balance'];


        Balance::create($request->all());
        return redirect()->route('balance.index', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
