<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        return response()->json(Ticket::all());
    }

    public function mostrarTickets()
    {
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $ticket = new Ticket();
        $ticket->name = $validatedData['name'];
        $ticket->email = $validatedData['email'];
        $ticket->title = $validatedData['title'];
        $ticket->cantidad = $validatedData['cantidad'];
        $ticket->price = $validatedData['price'];
        $ticket->save();

        return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente');
    }

    public function show($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(['error' => 'Ticket no encontrado'], 404);
        }

        return response()->json($ticket);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->name = $validatedData['name'];
        $ticket->email = $validatedData['email'];
        $ticket->title = $validatedData['title'];
        $ticket->cantidad = $validatedData['cantidad'];
        $ticket->price = $validatedData['price'];
        $ticket->save();

        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado correctamente');
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(['error' => 'Ticket no encontrado'], 404);
        }

        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado correctamente');
    }
}
