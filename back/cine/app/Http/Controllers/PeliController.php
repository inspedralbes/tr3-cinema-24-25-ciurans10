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
}
