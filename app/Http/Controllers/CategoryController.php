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
    public function index()
    {
        $categories = Category::all();
        return Inertia::render('category/index', ["categories"=>$categories]);
        //view('category.index', compact('categories'));
    }

    public function new()
    {
        $categories = Category::all();
        return Inertia::render('category/add', ["categories"=>$categories]);
        //view('category.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
          ]);

        Category::create($request->all());
          return redirect()->route('category.index')
            ->with('success','Se creó la categoria.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        return view('category.show', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
          ]);

          $category = Category::find($id);
          $category->update($request->all());
          return redirect()->route('category.index')
            ->with('success', 'La Categoria se ha actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('category.index')
            ->with('success', 'Se ha eliminado la categoria');
    }
}
