<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use App\Models\Recipe;
use App\Models\RecipeDetails;
use App\Models\Sector;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($updated = false)
    {
        $recipe = Recipe::all();
        $recipe->load('details', 'ingredients');
        $sector = Sector::all();
        $ingredients = Ingredients::all();

        $props = ["list_of"=>$recipe, "title"=>"Recetas", "href"=>"recipe", "add"=>true, "sector"=>$sector, "ingredients"=>$ingredients];
        
        if($updated){
            $props['updated'] = $updated;
            
        }

        return Inertia::render('tables/RecipeTable', $props);
    }

    public function new()
    {
        $section = Sector::all();
        $ingredients = Ingredients::all();
        return Inertia::render('form/Recipe', ["sections"=>$section, "ingredients"=>$ingredients]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //MAIN
        $recipe = Recipe::create(
            $request->get('step1')
        );
        
        $batch = 0;
        $unit = 0;
        //DETAILS
        foreach ($request->get('step1')['details'] as $value){
            if($value != []){
                $value['recipe_id'] = $recipe->id;
                $detail = RecipeDetails::create($value);    
                $batch += $detail->cost;
            }
            
        }
        $unit = $batch/$recipe->quantity;

        $batch = floatval(number_format($batch, 2));
        $unit = floatval(number_format($unit, 2));

        //UPDATE MAIN WITH CALCULATIONS
        $recipe->batch_cost = $batch;
        $recipe->unit_cost = $unit;

        $recipe->save();
        
        return redirect()->route('recipe.index', true);
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
