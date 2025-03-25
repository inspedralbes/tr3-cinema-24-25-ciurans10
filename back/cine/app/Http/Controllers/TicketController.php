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
        return json_decode($ticket->seats, true) ?? [];
    })->unique()->values();

    return response()->json([
        'ocupadas' => $butacasOcupadas
    ]);
    }

    public function resumenRecaudacion(Request $request)
    {
    $fecha = $request->query('fecha');

    $tickets = Ticket::where('selectedDate', $fecha)->get();

    $resumen = [
        'normal' => ['cantidad' => 0, 'recaudacion' => 0],
        'vip' => ['cantidad' => 0, 'recaudacion' => 0],
        'total' => 0
    ];

    foreach ($tickets as $ticket) {
        $seats = json_decode($ticket->seats, true);

        foreach ($seats as $butaca) {
            $fila = $butaca[0];
            $esVIP = $fila === 'F';

            if ($esVIP) {
                $resumen['vip']['cantidad']++;
                $resumen['vip']['recaudacion'] += $ticket->total / count($seats);
            } else {
                $resumen['normal']['cantidad']++;
                $resumen['normal']['recaudacion'] += $ticket->total / count($seats);
            }
        }
    }

    $resumen['total'] = $resumen['normal']['recaudacion'] + $resumen['vip']['recaudacion'];

    return response()->json($resumen);
    }

    public function verificarCompra(Request $request)
    {
    $validatedData = $request->validate([
        'peliculaId' => 'required|integer',
        'sessionTime' => 'required|string|max:255',
    ]);

    $user = $request->user();

    $existingTicket = Ticket::where('email', $user->email)
                            ->where('sessionTime', $validatedData['sessionTime'])
                            ->where('peliculaId', $validatedData['peliculaId'])
                            ->first();

    return response()->json([
        'existeCompra' => $existingTicket !== null,
        'compra' => $existingTicket,
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
        'peliculaId' => 'required|integer'
    ]);

    $ticket = new Ticket();
    $ticket->nombre = $validatedData['nombre'];
    $ticket->apellido = $validatedData['apellido'];
    $ticket->email = $request->user()->email;
    $ticket->seats = json_encode($validatedData['seats']);
    $ticket->selectedDate = $validatedData['selectedDate'];
    $ticket->sessionTime = $validatedData['sessionTime'];
    $ticket->total = $validatedData['total'];
    $ticket->peliculaId = $validatedData['peliculaId'];
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
   
    $ticket = Ticket::find($id);

    if (!$ticket) {
        return response()->json(['error' => 'Ticket no encontrado'], 404);
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
