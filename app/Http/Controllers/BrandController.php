<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($updated=false)
    {
        $brand = Brand::all();
        $props = ["list_of"=>$brand, "title"=>"Marcas", "href"=>"brand", "add"=>true];
        
        if($updated){
            $props['updated'] = $updated;
            
        }

        return Inertia::render('SmallRecords', $props);
    }

    public function new()
    {
        return Inertia::render('form/Brand');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
          ]);

        Brand::create($request->all());

        return redirect()->route('brand.index', true);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sector = Brand::find($id);
        return Inertia::render('form/Brand', ["model"=>$sector]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255'
          ]);

        $brand = Brand::find($id);
        
        $brand->update($request->all());
          
        return redirect()->route('brand.index', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        $brand->delete();
        return redirect()->route('brand.index', true);
    }
}
