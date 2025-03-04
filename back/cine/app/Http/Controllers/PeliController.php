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
            'price' => 'required|numeric'
        ]);

        $peli = Peli::create($request->all());

        return response()->json($peli, 201);
    }
}
