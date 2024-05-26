<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ver Imágenes - Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            max-height: 200px; /* Ajusta el máximo alto de la imagen */
            object-fit: cover; /* Ajusta cómo se ajusta la imagen dentro del contenedor */
        }
    </style>
</head>
<body class="bg-light">

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin') }}">
                <img src="{{ asset('imagenes/isaacnewton.jpg') }}" alt="ISAAC NEWTON" height="30" class="d-inline-block align-text-top">
                ISAAC NEWTON
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="{{ route('admin') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('ver.imagenes') }}">Ver Imágenes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('welcome') ? 'active' : '' }}" href="{{ route('ver.welcome') }}">Volver</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container mt-4">
    
    <div class="row mb-4">
        <div class="col">
            <form action="{{ route('filtra.imagenes') }}" method="GET" class="form-inline">
                <label for="mes" class="mr-2">Mes:</label>
                <select name="mes" id="mes" class="form-control mr-2">
                    <option value="">Todos</option>
                    <option value="01" {{ request('mes') == '01' ? 'selected' : '' }}>Enero</option>
                    <option value="02" {{ request('mes') == '02' ? 'selected' : '' }}>Febrero</option>
                    <option value="03" {{ request('mes') == '03' ? 'selected' : '' }}>Marzo</option>
                    <option value="04" {{ request('mes') == '04' ? 'selected' : '' }}>Abril</option>
                    <option value="05" {{ request('mes') == '05' ? 'selected' : '' }}>Mayo</option>
                    <option value="06" {{ request('mes') == '06' ? 'selected' : '' }}>Junio</option>
                    <option value="07" {{ request('mes') == '07' ? 'selected' : '' }}>Julio</option>
                    <option value="08" {{ request('mes') == '08' ? 'selected' : '' }}>Agosto</option>
                    <option value="09" {{ request('mes') == '09' ? 'selected' : '' }}>Septiembre</option>
                    <option value="10" {{ request('mes') == '10' ? 'selected' : '' }}>Octubre</option>
                    <option value="11" {{ request('mes') == '11' ? 'selected' : '' }}>Noviembre</option>
                    <option value="12" {{ request('mes') == '12' ? 'selected' : '' }}>Diciembre</option>
                </select>

                <label for="ano" class="mr-2">Año:</label>
                <select name="ano" id="ano" class="form-control mr-2">
                    @foreach(range(date("Y"), date("Y") + 5) as $ano)
                        <option value="{{ $ano }}" {{ request('ano') == $ano ? 'selected' : '' }}>{{ $ano }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>
    </div>

    <div class="row">
        @foreach ($imagenes as $img)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-primary shadow-sm">
                    <img src="{{ asset($img->imagen) }}" class="card-img-top img-fluid" alt="Imagen de {{ $img->name_alumno }}" onerror="this.src='{{ asset('imagenes/default.jpg') }}';">
                    <div class="card-body">
                        <h5 class="card-title">{{ $img->name_alumno }}</h5>
                        <p class="card-text">Nombre: {{ $img->name }}</p>
                        <p class="card-text">Grado: {{ $img->grado }}</p>
                        <p class="card-text">Sesión: {{ $img->sesion }}</p>
                        <p class="card-text">Fecha de creación: {{ $img->created_at->format('d/m/Y') }}</p>
                        <form action="{{ route('eliminar.imagen', $img->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
