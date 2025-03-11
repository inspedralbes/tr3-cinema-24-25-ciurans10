<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: #f8f9fa;
        }

        .container {
            max-width: 900px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="container mt-5 text-center">
        <h1 class="mb-4 text-primary">Panel de Administración</h1>

        <div class="row justify-content-center">
           
            <div class="col-md-4 mb-4">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title text-dark">🎬 Gestión de Películas</h5>
                        <p class="card-text text-muted">Agrega, edita y elimina películas.</p>
                        <a href="{{ route('peliculas.index') }}" class="btn btn-primary">Ir a Películas</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title text-dark">📅 Gestión de Sesiones</h5>
                        <p class="card-text text-muted">Crea, edita y elimina sesiones de cine.</p>
                        <a href="{{ route('sesiones.index') }}" class="btn btn-primary">Ir a Sesiones</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title text-dark">🎟 Gestión de Tickets</h5>
                        <p class="card-text text-muted">Vende y administra tickets de cine.</p>
                        <a href="{{ route('tickets.index') }}" class="btn btn-primary">Ir a Tickets</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
