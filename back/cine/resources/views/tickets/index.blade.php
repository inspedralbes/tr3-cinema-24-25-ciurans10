<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Listado de Tickets</h1>
        <a href="{{ route('home') }}" class="btn btn-secondary mb-3">Panel de Administración</a>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Agregar Nuevo Ticket</button>

        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Crear Nuevo Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre del Cliente</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="sesion_id" class="form-label">Sesión</label>
                                <input type="number" class="form-control" id="sesion_id" name="sesion_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Precio</label>
                                <input type="text" class="form-control" id="price" name="price" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabla de tickets -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Sesión</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->name }}</td>
                        <td>{{ $ticket->email }}</td>
                        <td>{{ $ticket->sesion_id }}</td>
                        <td>{{ $ticket->cantidad }}</td>
                        <td>${{ number_format($ticket->price, 2) }}</td>
                        <td>
                            <!-- Botón para editar -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $ticket->id }}">
                                Editar
                            </button>

                            <!-- Modal para editar ticket -->
                            <div class="modal fade" id="editModal{{ $ticket->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $ticket->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $ticket->id }}">Editar Ticket</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nombre del Cliente</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $ticket->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Correo Electrónico</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ $ticket->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="sesion_id" class="form-label">Sesión</label>
                                                    <input type="number" class="form-control" id="sesion_id" name="sesion_id" value="{{ $ticket->sesion_id }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="cantidad" class="form-label">Cantidad</label>
                                                    <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{ $ticket->cantidad }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Precio</label>
                                                    <input type="text" class="form-control" id="price" name="price" value="{{ $ticket->price }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón para eliminar -->
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
