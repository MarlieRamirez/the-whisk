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
    public function index()
    {
        $types = Sector::all();
        return Inertia::render('SmallRecords', ["list_of"=>$types, "title"=>"Secciones de Receta", "href"=>"types", "add"=>true]);
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
        
        $section = Sector::all();
        
        return Inertia::render('SmallRecords', ["list_of"=>$section, "title"=>"Secciones de Receta", "href"=>"types", "add"=>true])
            ->with('success','Se creó la categoria.');
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
          
        $sectors = Sector::all();
        
          return Inertia::render('SmallRecords', ["list_of"=>$sectors, "title"=>"Sección", "href"=>"types", "add"=>true])
            ->with('success', 'La Sección se ha actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
