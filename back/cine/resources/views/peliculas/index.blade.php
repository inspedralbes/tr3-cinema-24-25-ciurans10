<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Películas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            text-align: center;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 8px;
        }

        .btn-danger {
            background-color: #f44336;
        }

        .form-container {
            margin-bottom: 20px;
        }

        input[type="text"], input[type="date"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Lista de Películas</h1>

        @if(session('success'))
            <div class="message">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="form-container">
            <h2>Agregar Nueva Película</h2>
            <form action="{{ route('peliculas.store') }}" method="POST">
                @csrf
                <label for="title">Título:</label>
                <input type="text" name="title" id="title" required>
                
                <label for="poster_path">Ruta del Poster:</label>
                <input type="text" name="poster_path" id="poster_path" required>
                
                <label for="overview">Resumen:</label>
                <textarea name="overview" id="overview" required></textarea>
                
                <label for="release_date">Fecha de Estreno:</label>
                <input type="date" name="release_date" id="release_date" required>
                
                <label for="vote_average">Promedio de Voto:</label>
                <input type="number" name="vote_average" id="vote_average" step="0.1" min="0" max="10" required>
                
                <label for="price">Precio:</label>
                <input type="number" name="price" id="price" step="0.01" required>

                <button type="submit" class="btn">Guardar Película</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Poster</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peliculas as $peli)
                    <tr>
                        <td>{{ $peli->title }}</td> 
                        <td>
                            <img src="{{ $peli->poster_path }}" alt="{{ $peli->title }}" width="50">
                        </td>
                        <td>
                            <a href="{{ route('peliculas.show', $peli->id) }}" class="btn">Ver</a>
                            <a href="{{ route('peliculas.edit', $peli->id) }}" class="btn">Editar</a>

                            <form action="{{ route('peliculas.destroy', $peli->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta película?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
