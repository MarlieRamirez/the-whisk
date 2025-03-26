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
        $ingredients = Ingredients::all();
        $props = ["recipe" => $ingredients];

        return Inertia::render('form/Balance', $props);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    

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
