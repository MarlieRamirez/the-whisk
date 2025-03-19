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
        $recipe->load('details');
        
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
        $recipe = Recipe::find($id);
        $section = Sector::all();
        $ingredients = Ingredients::all();
        $recipe->load('details');
        return Inertia::render('form/Recipe', ["sections"=>$section, "ingredients"=>$ingredients, "recipe"=>$recipe]);
    }

    /**
     * Update the general and add other details
     */
    public function update(Request $request, string $id)
    {
        
        //MAIN
        $recipe = Recipe::find($id);
        $recipe->update($request->get('step1'));
        
        $batch = 0;
        $unit = 0;
        
        //DETAILS
        //delete existings
        RecipeDetails::where('recipe_id', '=', $recipe->id)->delete();

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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // RecipeDetails::where('recipe_id', '=', $id)->delete();
        $recipe = Recipe::find($id);
        $recipe->status = 0;
        $recipe->save();
        return redirect()->route('recipe.index', true);
    }

    //DETALLES
    public function details_index(string $id, $updated=false){
        $recipe = Recipe::all()->where('id','=', $id);
        $details = RecipeDetails::all()->where('recipe_id', '=', $id);
        $details->load('section', 'ingredient');


        $props = ["recipe"=>$recipe,"list_of"=>$details, "title"=>"Detalles de receta", "href"=>"details", "add"=>true];
        
        if($updated){
            $props['updated'] = $updated;
            
        }
        
        return Inertia::render('tables/DetailsTable', $props);
    }
    public function details_form(string $id)
    {
        $detail = RecipeDetails::find($id);
        $recipe = Recipe::find($detail->recipe_id);
        $section = Sector::all();
        $ingredients = Ingredients::all();
        

        return Inertia::render('form/RecipeDetailsForm', ["sections"=>$section, "ingredients"=>$ingredients, "recipe"=>$recipe, "detail"=>$detail]);
    }
     
    public function details_update(Request $request,string $id){

        $detail = RecipeDetails::find($id);
        $detail->update($request->all());
        $this->recount($detail->recipe_id);

        
        return redirect()->route('details.index', [$detail->recipe_id,true]);
    }

    public function details_destroy(string $id){
        $recipe = RecipeDetails::find($id);
        $recipe_id = $recipe->recipe_id;
        $recipe->delete();
        
        $this->recount($recipe_id);
        return redirect()->route('details.index', [$recipe_id,true]);
    }

    public function recount($recipe_id){

        $recipe = Recipe::find($recipe_id);
        $array = RecipeDetails::all()->where('recipe_id', '=', $recipe_id);
        
        $batch = 0;

        foreach ($array as $value){
            $batch += $value->cost;
        }

        $unit = $batch/$recipe->quantity;

        $batch = floatval(number_format($batch, 2));
        $unit = floatval(number_format($unit, 2));
        
        $recipe->batch_cost = $batch;
        $recipe->unit_cost = $unit;

        $recipe->save();
    }
}
