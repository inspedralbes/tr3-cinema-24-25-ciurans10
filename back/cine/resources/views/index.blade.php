<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4">Panel de Administración</h1>

        <div class="row">
           
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gestión de Películas</h5>
                        <p class="card-text">Agrega, edita y elimina películas.</p>
                        
                        <a href="{{ route('peliculas.index') }}" class="btn btn-primary">Ir a Películas</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gestión de Sesiones</h5>
                        <p class="card-text">Crea, edita y elimina sesiones de cine.</p>
                        <a href="{{ route('sesiones.index') }}" class="btn btn-primary">Ir a Sesiones</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gestión de Tickets</h5>
                        <p class="card-text">Vende y administra tickets de cine.</p>
                        <a href="{{ route('tickets.index') }}" class="btn btn-primary">Ir a Tickets</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
