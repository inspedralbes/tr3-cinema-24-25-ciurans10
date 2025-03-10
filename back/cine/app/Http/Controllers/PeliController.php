<?php

namespace App\Http\Controllers;

use App\Models\Peli;
use Illuminate\Http\Request;

class PeliController extends Controller
{
    
    public function index()
    {
        return response()->json(Peli::all());
    }

    public function mostrarPeliculas()
    {
        $peliculas = Peli::all();  
        return view('peliculas.index', compact('peliculas'));  
    }

    public function store(Request $request)
{
    
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'poster_path' => 'required|string',
        'release_date' => 'required|date',
        'vote_average' => 'required|numeric|min:0|max:10',
    ]);

    $peli = new Peli(); 
    $peli->title = $validatedData['title'];
    $peli->poster_path = $validatedData['poster_path'];
    $peli->release_date = $validatedData['release_date'];
    $peli->vote_average = $validatedData['vote_average'];

    $peli->save();

    return redirect()->route('peliculas.index')->with('success', 'Película creada exitosamente');
}


    public function show($id)
    {
        $peli = Peli::find($id);

        if (!$peli) {
            return response()->json(['error' => 'Película no encontrada'], 404);
        }

        return response()->json($peli);
    }

    public function update(Request $request, $id)
{
    
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'poster_path' => 'required|string',
        'release_date' => 'required|date',
        'vote_average' => 'required|numeric|min:0|max:10',
    ]);

    $peli = Peli::findOrFail($id);

    $peli->title = $validatedData['title'];
    $peli->poster_path = $validatedData['poster_path'];
    $peli->release_date = $validatedData['release_date'];
    $peli->vote_average = $validatedData['vote_average'];

    $peli->save();

    return redirect()->route('peliculas.index')->with('success', 'Película actualizada correctamente');
}


    public function destroy($id)
    {
        $peli = Peli::find($id);

        if (!$peli) {
            return response()->json(['error' => 'Película no encontrada'], 404);
        }

        $peli->delete();

        return redirect()->route('peliculas.index')->with('success', 'Película eliminada correctamente');
    }
}
