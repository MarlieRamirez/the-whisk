<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($updated=false)
    {
        $categories = Category::all();
        $props = ["list_of"=>$categories, "title"=>"Categorias", "href"=>"category", "add"=>true];
        
        if($updated){
            $props['updated'] = $updated;
            
        }

        return Inertia::render('SmallRecords', $props);
        //view('category.index', compact('categories'));
    }

    public function new()
    {
        return Inertia::render('form/Category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
          ]);

        Category::create($request->all());
        
        return redirect()->route('category.index', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        return Inertia::render('form/Category', ["model"=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255'
          ]);

        $category = Category::find($id);
        
        $category->update($request->all());
          
        return redirect()->route('category.index', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('category.index', true);
    }
}
