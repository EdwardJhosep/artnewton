<!DOCTYPE html>
<html lang="es">
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

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<main class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <form action="{{ route('ver.imagenes') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="month" class="visually-hidden">Selecciona Mes</label>
                    <select name="month" id="month" class="form-select">
                        <option value="">Selecciona Mes</option>
                        @foreach([
                            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
                            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
                            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
                            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                        ] as $key => $mes)
                            <option value="{{ $key }}" {{ Request::get('month') == $key ? 'selected' : '' }}>
                                {{ $mes }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <label for="year" class="visually-hidden">Selecciona Año</label>
                    <select name="year" id="year" class="form-select">
                        <option value="">Selecciona Año</option>
                        @foreach(range(date("Y"), 2010) as $y)
                            <option value="{{ $y }}" {{ Request::get('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        @forelse ($imagenes as $img)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-primary shadow-sm">
                    <img src="{{ asset($img->imagen) }}" class="card-img-top img-fluid" alt="Imagen de {{ $img->name_alumno }}" onerror="this.src='{{ asset('imagenes/placeholder.png') }}'">
                    <div class="card-body">
                        <h5 class="card-title">{{ $img->name_alumno }}</h5>
                        <p class="card-text"><strong>Grado:</strong> {{ $img->grado }}</p>
                        <p class="card-text"><strong>Sesión:</strong> {{ $img->sesion }}</p>
                        <form action="{{ route('eliminar.imagen', $img->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta imagen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No se encontraron imágenes.
                </div>
            </div>
        @endforelse
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
