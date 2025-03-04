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
            'price' => 'required|int|max:255',
            'poster' => 'required|string|max:255',
        ]);

        $movie = new Peli();
        $movie->title = $validated['title'];
        $movie->price = $validated['price'];
        $movie->poster = $validated['poster'];
        $movie->save();

        return response()->json($movie, 201); 
    }
}
