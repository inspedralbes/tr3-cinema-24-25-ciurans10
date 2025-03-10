<?php


namespace App\Http\Controllers;

use App\Models\SessionPeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SessionPeliController extends Controller
{
    public function index()
    {
        $sesiones = SessionPeli::all();

        return view('sesiones.index', compact('sesiones'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'poster_path' => 'required|string',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        SessionPeli::create([
            'title' => $validatedData['title'],
            'date' => $validatedData['date'],
            'time' => $validatedData['time'],
            'poster_path' => $validatedData['poster_path']
        ]);

        return redirect()->route('sesiones.index')->with('success', 'Sesión agregada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'poster_path' => 'required|string',
        ]);

        $sesion = SessionPeli::findOrFail($id);

        if ($request->hasFile('image')) {
            
            Storage::disk('public')->delete($sesion->image);

            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = $sesion->image; 
        }

        $sesion->update([
            'title' => $validatedData['title'],
            'date' => $validatedData['date'],
            'time' => $validatedData['time'],
            'poster_path' => $validatedData['poster_path'],
        ]);

        return redirect()->route('sesiones.index')->with('success', 'Sesión actualizada correctamente.');
    }

    public function destroy($id)
    {
        $sesion = SessionPeli::findOrFail($id);

        Storage::disk('public')->delete($sesion->image);

        $sesion->delete();

        return redirect()->route('sesiones.index')->with('success', 'Sesión eliminada correctamente.');
    }
}

