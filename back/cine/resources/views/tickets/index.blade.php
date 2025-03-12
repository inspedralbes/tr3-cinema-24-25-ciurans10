<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .modal-content {
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-primary">🎟️ Listado de Tickets</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">🏠 Panel de Administración</a>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">➕ Agregar Ticket</button>
        </div>

        <div class="modal fade" id="createModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Crear Nuevo Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Apellido</label>
                                <input type="text" class="form-control" name="apellido" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Asientos</label>
                                <input type="text" class="form-control" name="seats" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha</label>
                                <input type="date" class="form-control" name="selectedDate" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Horario</label>
                                <input type="text" class="form-control" name="sessionTime" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Total</label>
                                <input type="number" class="form-control" name="total" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Asientos</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->nombre }}</td>
                            <td>{{ $ticket->apellido }}</td>
                            <td>{{ $ticket->telefono }}</td>
                            <td>{{ implode(", ", json_decode($ticket->seats)) }}</td>
                            <td>{{ $ticket->selectedDate }}</td>
                            <td>{{ $ticket->sessionTime }}</td>
                            <td>${{ number_format($ticket->total, 2) }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $ticket->id }}">✏️ Editar</button>
                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">🗑️ Eliminar</button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="editModal{{ $ticket->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-white">
                                        <h5 class="modal-title">Editar Ticket</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" value="{{ $ticket->nombre }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apellido</label>
                                                <input type="text" class="form-control" name="apellido" value="{{ $ticket->apellido }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Teléfono</label>
                                                <input type="text" class="form-control" name="telefono" value="{{ $ticket->telefono }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Asientos</label>
                                                <input type="text" class="form-control" name="seats" value="{{ implode(", ", json_decode($ticket->seats)) }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Fecha</label>
                                                <input type="date" class="form-control" name="selectedDate" value="{{ $ticket->selectedDate }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Horario</label>
                                                <input type="text" class="form-control" name="sessionTime" value="{{ $ticket->sessionTime }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Total</label>
                                                <input type="number" class="form-control" name="total" value="{{ $ticket->total }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
