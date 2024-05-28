<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bienvenido a ARTNEWTON</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .image-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .image-card:hover {
            transform: scale(1.03);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            display: flex;
            flex-direction: column;
        }

        .card-title {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .card-text {
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .comments-container {
            max-height: 150px;
            overflow-y: auto;
            padding-right: 10px;
            margin-top: 10px;
        }

        .comments-container p {
            margin-bottom: 5px;
        }

        .comment {
            background-color: #f5f5f5;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .comment strong {
            font-weight: bold;
            color: black;
        }

        .comment p {
            color: blue;
        }

        .toggle-comments {
            margin-top: 5px;
        }

        .comment-form {
            margin-top: 10px;
        }

        .alert {
            font-size: 14px;
        }

        .alert-success {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
        }

        .card-img-link {
            display: block;
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .card-img-link:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="imagenes/isaacnewton.jpg" alt="Logo" class="rounded-circle" width="40" height="40">
                <span class="ms-2">ARTNEWTON</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
                <form class="d-flex" id="filterForm" action="{{ route('filtrar.imagenes') }}" method="GET">
                    <select class="form-select me-2 bg-dark text-white" aria-label="Filtro de mes" id="monthFilter" name="mes">
                        <option value="">Seleccionar mes</option>
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                    <select class="form-select me-2 bg-dark text-white" aria-label="Filtro de año" id="yearFilter" name="ano">
                        <option value="">Seleccionar año</option>
                        <option value="2024">2024</option>
                        <option value="2024">2025</option>
                        <option value="2026">2026</option>
                        <option value="2025">2027</option>
                        <option value="2024">2028</option>
                    </select>
                    <button class="btn btn-primary" type="submit">Filtrar</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="container mt-4">
        @if(session('error'))
        <div class="alert alert-warning alert-dismissible fade show mt-4 animate__animated animate__bounceInRight" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4 animate__animated animate__bounceInRight" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($imagenes->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="imageContainer">
            @foreach ($imagenes as $img)
            <div class="col mb-4">
                <div class="card bg-light text-dark shadow-sm image-card h-100" data-month="{{ date('n', strtotime($img->created_at)) }}" data-year="{{ date('Y', strtotime($img->created_at)) }}">
                    <a href="#" class="card-img-link" data-bs-toggle="modal" data-bs-target="#imageModal{{$img->id}}">
                        <img src="{{ asset($img->imagen) }}" class="card-img-top img-fluid" alt="Imagen de {{ $img->name_alumno }}" onerror="this.src='imagenes/default.jpg';">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $img->name_alumno }}</h5>
                        <p class="card-text">Título: {{ $img->name }}</p>
                        <p class="card-text">Grado: {{ $img->grado }}</p>
                        <p class="card-text">Sesion: {{ $img->sesion }}</p>
                        <div class="comments-container">
                            <h6>Comentarios:</h6>
                            <div class="comments-list" style="display: none;">
                                @foreach($img->comentarios as $comentario)
                                    <div class="comment">
                                        <strong>{{ $comentario->comentarista }}:</strong>
                                        <p>{{ $comentario->comentario }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <button class="btn btn-success btn-sm toggle-comments mt-2">Mostrar Comentarios</button>
                        </div>
                        <button class="btn btn-primary btn-sm mt-2 mb-2 toggle-comment-form">Comentar</button>
                        <form action="{{ route('store.comment', $img->id) }}" method="POST" class="comment-form d-none">
                            @csrf
                            <div class="mb-3">
                                <label for="comentarista" class="form-label">Tu nombre completo:</label>
                                <input type="text" class="form-control" id="comentarista" name="comentarista" required>
                            </div>
                            <div class="mb-3">
                                <label for="comentario" class="form-label">Tu comentario:</label>
                                <textarea class="form-control" id="comentario" name="comentario" rows="2" maxlength="100" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                        <form action="{{ route('like.image', $img->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary" onclick="likeImage({{ $img->id }})">
                                Me gusta <span id="likeBadge{{ $img->id }}" class="badge bg-primary">{{ $img->likes->likes ?? 0 }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal para mostrar imagen -->
            <div class="modal fade" id="imageModal{{$img->id}}" tabindex="-1" aria-labelledby="imageModalLabel{{$img->id}}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel{{$img->id}}">Imagen de {{ $img->name_alumno }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ asset($img->imagen) }}" class="img-fluid" alt="Imagen de {{ $img->name_alumno }}" onerror="this.src='imagenes/default.jpg';">
                            <div class="mt-3">
                                <p><strong>Título:</strong> {{ $img->name }}</p>
                                <p><strong>Grado:</strong> {{ $img->grado }}</p>
                                <p><strong>Sesión:</strong> {{ $img->sesion }}</p>
                            </div>
                            <div class="comments-container mt-3">
                                <h6>Comentarios:</h6>
                                <div class="comments-list">
                                    @foreach($img->comentarios as $comentario)
                                        <div class="comment">
                                            <strong>{{ $comentario->comentarista }}:</strong>
                                            <p>{{ $comentario->comentario }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center mt-4">No hay imágenes disponibles.</p>
        @endif
    </main>
    
    <footer class="footer mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; 2023 ARTNEWTON. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-comments').forEach(function(button) {
                button.addEventListener('click', function() {
                    var commentsList = this.previousElementSibling;
                    if (commentsList.style.display === 'none' || commentsList.style.display === '') {
                        commentsList.style.display = 'block';
                        this.textContent = 'Ocultar Comentarios';
                    } else {
                        commentsList.style.display = 'none';
                        this.textContent = 'Mostrar Comentarios';
                    }
                });
            });

            document.querySelectorAll('.toggle-comment-form').forEach(function(button) {
                button.addEventListener('click', function() {
                    var form = this.nextElementSibling;
                    if (form.classList.contains('d-none')) {
                        form.classList.remove('d-none');
                    } else {
                        form.classList.add('d-none');
                    }
                });
            });
        });

        function likeImage(imageId) {
            var likeBadge = document.getElementById('likeBadge' + imageId);
            var currentLikes = parseInt(likeBadge.textContent);
            likeBadge.textContent = currentLikes + 1;
        }
    </script>
</body>
</html>
