<?php

namespace App\Http\Controllers;

use App\Models\Peli;
use Illuminate\Http\Request;

class PeliController extends Controller
{
    public function store(Request $request)
    {
      
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'poster_path' => 'required|string|max:255',
            'vote_average' => 'nullable|int', 
        ]);

        $movie = new Peli();
        $movie->title = $validated['title'];
        $movie->poster_path = $validated['poster_path'];
        $movie->vote_average = $validated['vote_average'] ?? 0;  
        $movie->save();

        return response()->json($movie, 201);
    }
}

