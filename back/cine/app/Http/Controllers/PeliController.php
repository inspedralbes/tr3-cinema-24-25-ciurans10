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
        $request->validate([
            'title' => 'required|string|max:255',
            'poster_path' => 'required|string',
            'overview' => 'required|string',
            'release_date' => 'required|date',
            'vote_average' => 'required|numeric|min:0|max:10',
            'price' => 'required|numeric',
        ]);

        $peli = Peli::create($request->all());

        return response()->json($peli, 201);
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
        $peli = Peli::find($id);

        if (!$peli) {
            return response()->json(['error' => 'Película no encontrada'], 404);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'poster_path' => 'sometimes|string',
            'overview' => 'sometimes|string',
            'release_date' => 'sometimes|date',
            'vote_average' => 'sometimes|numeric|min:0|max:10',
            'price' => 'sometimes|numeric',
        ]);

        $peli->update($request->all());

        return response()->json($peli);
    }

    public function destroy($id)
    {
        $peli = Peli::find($id);

        if (!$peli) {
            return response()->json(['error' => 'Película no encontrada'], 404);
        }

        $peli->delete();

        return response()->json(['message' => 'Película eliminada correctamente']);
    }
}
