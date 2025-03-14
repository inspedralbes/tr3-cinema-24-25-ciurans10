<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
  
    public function index()
    {
        return response()->json(Ticket::all(), 200);
    }

    public function mostrarTickets()
    {
        $tickets = Ticket::all();  
        return view('tickets.index', compact('tickets'));
    }

    public function obtenerButacasOcupadas()
    {
    $butacasOcupadas = Ticket::all()->flatMap(function ($ticket) {
        return json_decode($ticket->seats, true);
    })->unique()->values();

    return response()->json([
        'ocupadas' => $butacasOcupadas
    ]);
    }

    public function store(Request $request)
    {
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'seats' => 'required|array|min:1',
        'selectedDate' => 'required|date',
        'sessionTime' => 'required|string|max:255',
        'total' => 'required|numeric',
    ]);

    $ticket = new Ticket();
    $ticket->nombre = $validatedData['nombre'];
    $ticket->apellido = $validatedData['apellido'];
    $ticket->email = $validatedData['email'];
    $ticket->seats = json_encode($validatedData['seats']);
    $ticket->selectedDate = $validatedData['selectedDate'];
    $ticket->sessionTime = $validatedData['sessionTime'];
    $ticket->total = $validatedData['total'];
    $ticket->save();

    return response()->json([
        'message' => 'Ticket creado correctamente',
        'ticket' => $ticket
    ], 201);
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
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'seats' => 'required|array|min:1',
            'selectedDate' => 'required|date',
            'sessionTime' => 'required|string|max:255',
            'total' => 'required|numeric',
        ]);

        $ticket = Ticket::findOrFail($id); 

        $ticket->nombre = $validatedData['nombre'];
        $ticket->apellido = $validatedData['apellido'];
        $ticket->email = $validatedData['email'];
        $ticket->seats = json_encode($validatedData['seats']);
        $ticket->selectedDate = $validatedData['selectedDate'];
        $ticket->sessionTime = $validatedData['sessionTime'];
        $ticket->total = $validatedData['total'];
        $ticket->save();

        return response()->json([
            'message' => 'Ticket actualizado correctamente',
            'ticket' => $ticket
        ]);
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(['error' => 'Ticket no encontrado'], 404);
        }

        $ticket->delete();

        return response()->json(['message' => 'Ticket eliminado correctamente']);
    }
}
