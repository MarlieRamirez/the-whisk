<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
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

        $props = ["list_of"=>$recipe, "title"=>"Recetas", "href"=>"ingredient", "add"=>true, "sector"=>$sector];
        
        if($updated){
            $props['updated'] = $updated;
            
        }

        return Inertia::render('tables/RecipeTable', $props);
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
