<?php

namespace App\Http\Controllers;

use App\Models\SessionPeli;
use Illuminate\Http\Request;

class SessionPeliController extends Controller
{
    public function index()
    {
        return response()->json(SessionPeli::all());
    }

    public function mostrarSesiones()
    {
        $sesiones = SessionPeli::all();  
        return view('sesiones.index', compact('sesiones'));  
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'poster_path' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $sesion = new SessionPeli(); 
        $sesion->title = $validatedData['title'];
        $sesion->poster_path = $validatedData['poster_path'];
        $sesion->date = $validatedData['date'];
        $sesion->time = $validatedData['time'];

        $sesion->save();

        return redirect()->route('sesiones.index')->with('success', 'Sesión creada exitosamente');
    }

    public function show($id)
    {
        $sesion = SessionPeli::find($id);

        if (!$sesion) {
            return response()->json(['error' => 'Sesión no encontrada'], 404);
        }

        return response()->json($sesion);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'poster_path' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $sesion = SessionPeli::findOrFail($id);

        $sesion->title = $validatedData['title'];
        $sesion->poster_path = $validatedData['poster_path'];
        $sesion->date = $validatedData['date'];
        $sesion->time = $validatedData['time'];

        $sesion->save();

        return redirect()->route('sesiones.index')->with('success', 'Sesión actualizada correctamente');
    }

    public function destroy($id)
    {
        $sesion = SessionPeli::find($id);

        if (!$sesion) {
            return response()->json(['error' => 'Sesión no encontrada'], 404);
        }

        $sesion->delete();

        return redirect()->route('sesiones.index')->with('success', 'Sesión eliminada correctamente');
    }
}
