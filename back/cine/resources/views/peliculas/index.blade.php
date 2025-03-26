<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat de Pel·lícules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .movie-poster {
            width: 80px;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .modal-content {
            border-radius: 10px;
        }
        .btn-sm {
            font-size: 0.85rem;
        }
       
        .col-estreno{
            width: 100px;
        } 
        .col-acciones {
            width: 200px; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-primary">🎬 Llistat de Pel·lícules</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">🏠 Panell d'Administració</a>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">➕ Afegir Pel·lícula</button>
        </div>

        <div class="modal fade" id="createModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Afegir Nova Pel·lícula</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('peliculas.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Títol</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Poster (URL)</label>
                                <input type="text" class="form-control" name="poster_path" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Estrena</label>
                                <input type="date" class="form-control" name="release_date" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Qualificació</label>
                                <input type="number" class="form-control" name="vote_average" min="0" max="10" step="0.1" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                            <button type="submit" class="btn btn-primary">Desar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Títol</th>
                    <th>Poster</th>
                    <th class="col-estreno">Estrena</th>
                    <th>Qualificació</th>
                    <th class="col-acciones">Accions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peliculas as $peli)
                    <tr>
                        <td>{{ $peli->id }}</td>
                        <td>{{ $peli->title }}</td>
                        <td><img src="{{ $peli->poster_path }}" class="movie-poster"></td>
                        <td>{{ $peli->release_date }}</td>
                        <td>{{ $peli->vote_average }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $peli->id }}">✏️ Editar</button>
                            <form action="{{ route('peliculas.destroy', $peli->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">🗑️ Eliminar</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editModal{{ $peli->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title">Editar Pel·lícula</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('peliculas.update', $peli->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Títol</label>
                                            <input type="text" class="form-control" name="title" value="{{ $peli->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Poster (URL)</label>
                                            <input type="text" class="form-control" name="poster_path" value="{{ $peli->poster_path }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Estrena</label>
                                            <input type="date" class="form-control" name="release_date" value="{{ $peli->release_date }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Qualificació</label>
                                            <input type="number" class="form-control" name="vote_average" value="{{ $peli->vote_average }}" min="0" max="10" step="0.1" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                                        <button type="submit" class="btn btn-primary">Desar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
