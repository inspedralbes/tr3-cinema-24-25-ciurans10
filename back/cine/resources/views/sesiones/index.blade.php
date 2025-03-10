<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Sesiones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Listado de Sesiones</h1>

        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Agregar Nueva Sesión</button>

        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Crear Nueva Sesión</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form action="{{ route('sesiones.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Título</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="poster_path" class="form-label">Poster</label>
                                <input type="text" class="form-control" id="poster_path" name="poster_path" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">Hora</label>
                                <input type="time" class="form-control" id="time" name="time" required>
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

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Poster</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sesiones as $sesion)
                    <tr>
                        <td>{{ $sesion['id'] }}</td> 
                        <td>{{ $sesion['title'] }}</td>
                        <td>
                            <img src="{{ $sesion['poster_path'] }}" alt="{{ $sesion['title'] }}" style="width: 100px; height: auto;">
                        </td>
                        <td>{{ $sesion['date'] }}</td>
                        <td>{{ $sesion['time'] }}</td>
                        <td>
                            
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $sesion['id'] }}">
                                Editar
                            </button>

                            <div class="modal fade" id="editModal{{ $sesion['id'] }}" tabindex="-1" aria-labelledby="editModalLabel{{ $sesion['id'] }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $sesion['id'] }}">Editar Sesión</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <form action="{{ route('sesiones.update', $sesion['id']) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Título</label>
                                                    <input type="text" class="form-control" id="title" name="title" value="{{ $sesion['title'] }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="poster_path" class="form-label">Poster</label>
                                                    <input type="text" class="form-control" id="poster_path" name="poster_path" value="{{ $sesion['poster_path'] }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">Fecha</label>
                                                    <input type="date" class="form-control" id="date" name="date" value="{{ $sesion['date'] }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="time" class="form-label">Hora</label>
                                                    <input type="time" class="form-control" id="time" name="time" value="{{ $sesion['time'] }}" required>
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

                            <form action="{{ route('sesiones.destroy', $sesion['id']) }}" method="POST" style="display:inline;">
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
