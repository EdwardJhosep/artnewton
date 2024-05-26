<!-- admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <title>Subir Imagen - Panel de Administrador</title>
</head>
<body class="bg-light">
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin') }}">
                <img src="{{ asset('imagenes/isaacnewton.jpg') }}" alt="Isaac Newton Logo" height="30" class="d-inline-block align-text-top">
                ISAAC NEWTON
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('admin') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ver.imagenes') }}">Ver Imagenes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ver.welcome') }}">Volver</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h1 class="text-center mb-4">Subir Imagen</h1>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ $message }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="text-center mb-4">
                    <img src="{{ Storage::url('images/' . Session::get('image')) }}" class="img-fluid img-thumbnail" alt="Imagen subida">
                </div>
            @endif
            <form action="{{ route('subir.imagen') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nombre_imagen" class="form-label">Nombre de la Imagen:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-image"></i></span>
                        <input type="text" class="form-control" id="nombre_imagen" name="nombre_imagen" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="nombre_alumno" class="form-label">Nombre del Alumno:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="nombre_alumno" name="nombre_alumno" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="grado" class="form-label">Grado:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-book"></i></span>
                            <input type="text" class="form-control" id="grado" name="grado" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="sesion" class="form-label">Sesión:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-clock"></i></span>
                            <input type="text" class="form-control" id="sesion" name="sesion" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Seleccionar Imagen:</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                        <label class="input-group-text" for="imagen"><i class="bi bi-upload"></i></label>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-cloud-upload"></i> Subir Imagen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
