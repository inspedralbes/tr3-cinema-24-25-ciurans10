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
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Poster</th>
                    <th>Fecha de Estreno</th>
                    <th>Calificación</th>
                    <th>Precio</th>
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
                        <td>${{ $peli->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
    