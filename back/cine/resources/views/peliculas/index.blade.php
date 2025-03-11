<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Películas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Listado de Películas</h1>
        <a href="{{ route('home') }}" class="btn btn-secondary mb-3">Panel de Administración</a>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Agregar Nueva Película</button>

        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"> 
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Crear Nueva Película</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form action="{{ route('peliculas.store') }}" method="POST">
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
                                <label for="release_date" class="form-label">Fecha de Estreno</label>
                                <input type="date" class="form-control" id="release_date" name="release_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="vote_average" class="form-label">Calificación</label>
                                <input type="number" step="0.1" min="0" max="10" class="form-control" id="vote_average" name="vote_average" required>
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
                    <th>Fecha de Estreno</th>
                    <th>Calificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peliculas as $peli)
                    <tr>
                        <td>{{ $peli->id }}</td>
                        <td>{{ $peli->title }}</td>
                        <td><img src="{{ $peli->poster_path }}" alt="Poster" width="50"></td>
                        <td>{{ $peli->release_date }}</td>
                        <td>{{ $peli->vote_average }}</td>
                        <td>
                            
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $peli->id }}">
                                Editar
                            </button>

                            <div class="modal fade" id="editModal{{ $peli->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $peli->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $peli->id }}">Editar Película</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <form action="{{ route('peliculas.update', $peli->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Título</label>
                                                    <input type="text" class="form-control" id="title" name="title" value="{{ $peli->title }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="poster_path" class="form-label">Poster</label>
                                                    <input type="text" class="form-control" id="poster_path" name="poster_path" value="{{ $peli->poster_path }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="release_date" class="form-label">Fecha de Estreno</label>
                                                    <input type="date" class="form-control" id="release_date" name="release_date" value="{{ $peli->release_date }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="vote_average" class="form-label">Calificación</label>
                                                    <input type="number" step="0.1" min="0" max="10" class="form-control" id="vote_average" name="vote_average" value="{{ $peli->vote_average }}" required>
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

                            <form action="{{ route('peliculas.destroy', $peli->id) }}" method="POST" style="display:inline;">
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
