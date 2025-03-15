<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($updated=false)
    {
        $types = Sector::all();
        $props = ["list_of"=>$types, "title"=>"Secciones de Receta", "href"=>"type", "add"=>true];
        
        if($updated){
            $props['updated'] = $updated;
            
        }

        return Inertia::render('SmallRecords', $props);
        //view('category.index', compact('categories'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function new()
    {
        return Inertia::render('form/Section');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
          ]);

        Sector::create($request->all());
        
        return redirect()->route('types.index', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sector = Sector::find($id);
        return Inertia::render('form/Section', ["model"=>$sector]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255'
          ]);

        $sector = Sector::find($id);
        
        $sector->update($request->all());
        //$this->index(true);
        return redirect()->route('types.index', true);
        //return;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Sector::find($id);
        $brand->delete();
        return redirect()->route('types.index', true);
    }
}
