<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
  
    public function index(Request $request)
    {
    $user = $request->user(); 
    $tickets = Ticket::where('email', $user->email)->get();

    return response()->json($tickets, 200);
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
    $ticket->email = $request->user()->email;
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


    public function show(Request $request, $id)
    {
    $user = $request->user();
    $ticket = Ticket::where('id', $id)->where('email', $user->email)->first();

    if (!$ticket) {
        return response()->json(['error' => 'Ticket no encontrado o no autorizado'], 403);
    }

    return response()->json($ticket);
    }


    public function update(Request $request, $id)
{
    $user = $request->user();
    $ticket = Ticket::where('id', $id)->where('email', $user->email)->first();

    if (!$ticket) {
        return response()->json(['error' => 'No autorizado para modificar este ticket'], 403);
    }

    $validatedData = $request->validate([
        'seats' => 'required|array|min:1',
        'selectedDate' => 'required|date',
        'sessionTime' => 'required|string|max:255',
        'total' => 'required|numeric',
    ]);

    $ticket->seats = json_encode($validatedData['seats']);
    $ticket->selectedDate = $validatedData['selectedDate'];
    $ticket->sessionTime = $validatedData['sessionTime'];
    $ticket->total = $validatedData['total'];
    $ticket->save();

    return response()->json(['message' => 'Ticket actualizado correctamente', 'ticket' => $ticket]);
}

public function destroy(Request $request, $id)
{
    $user = $request->user();
    $ticket = Ticket::where('id', $id)->where('email', $user->email)->first();

    if (!$ticket) {
        return response()->json(['error' => 'No autorizado para eliminar este ticket'], 403);
    }

    $ticket->delete();

    return response()->json(['message' => 'Ticket eliminado correctamente']);
}

}
