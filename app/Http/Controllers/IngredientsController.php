<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Ingredients;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IngredientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($updated=false)
    {
        $ingredients = Ingredients::all();
        $ingredients->load('category', 'brand');
        $props = ["list_of"=>$ingredients, "title"=>"Ingredientes", "href"=>"ingredient", "add"=>true];
        
        if($updated){
            $props['updated'] = $updated;
            
        }

        return Inertia::render('tables/IngredientsTable', $props);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function new()
    {
        $categories = Category::all();
        $brand = Brand::all();

        return Inertia::render('form/Ingredients', ["categories"=>$categories,"brand"=>$brand]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //VALIDATE
        $request->validate([
            'name' => 'required|max:255',
          ]);

        Ingredients::create($request->all());
        
        return redirect()->route('ingredient.index', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sector = Ingredients::find($id);
        $categories = Category::all();
        $brand = Brand::all();

        return Inertia::render('form/Ingredients', ["model"=>$sector, "categories"=>$categories,"brand"=>$brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //VALIDATE
        $request->validate([
            'name' => 'required|max:255'
          ]);

        $ingredient = Ingredients::find($id);
        
        $ingredient->update($request->all());
        //$this->index(true);
        return redirect()->route('ingredient.index', true);
        //return;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ingredient = Ingredients::find($id);
        $ingredient->delete();
        return redirect()->route('ingredient.index', true);
    }
}
