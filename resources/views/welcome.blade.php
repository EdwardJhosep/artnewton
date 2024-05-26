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
        }

        .comment-button {
            align-self: flex-end;
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
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                    <button class="btn btn-primary" type="submit">Filtrar</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="container mt-4">
        <div id="noImagesMessage" class="alert alert-warning d-none fade show" role="alert">
            No hay imágenes disponibles para el mes y año seleccionados. <span id="recommendation"></span>
        </div>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4 animate__animated animate__bounceInRight" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="imageContainer">
            @foreach ($imagenes as $img)
            <div class="col mb-4">
                <div class="card bg-light text-dark shadow-sm image-card h-100 fade show animate__animated animate__fadeInUp" data-month="{{ date('n', strtotime($img->created_at)) }}" data-year="{{ date('Y', strtotime($img->created_at)) }}">
                    <img src="{{ asset($img->imagen) }}" class="card-img-top img-fluid" alt="Imagen de {{ $img->name_alumno }}" onerror="this.src='imagenes/default.jpg';">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title animate__animated animate__pulse animate__infinite infinite">{{ $img->name_alumno }}</h5>
                        <p class="card-text"><strong>Nombre:</strong> {{ $img->name }}</p>
                        <p class="card-text"><strong>Grado:</strong> {{ $img->grado }}</p>
                        <p class="card-text"><strong>Sesión:</strong> {{ $img->sesion }}</p>
            
                        <!-- Comentarios -->
                        <div class="mt-3">
                            <h6>Comentarios:</h6>
                            <div class="comments-container">
                                @if ($img->comentarios->isNotEmpty())
                                    @foreach ($img->comentarios as $comentario)
                                        <div class="comment">
                                            <strong>{{ $comentario->comentarista }}</strong>: {{ $comentario->comentario }}
                                        </div>
                                    @endforeach
                                @else
                                    <p>No hay comentarios aún.</p>
                                @endif
                            </div>
                            <!-- Botón para mostrar los comentarios -->
                            <button class="btn btn-primary btn-sm mt-2 show-comments">Ver comentarios</button>
                        </div>
            
                        <!-- Formulario de comentarios -->
                        <div class="mt-3">
                            <button class="btn btn-primary btn-sm mt-2 mb-2 comment-button">Comentar</button>
                            <div class="comment-form d-none">
                                <form action="{{ route('comentar.imagen', ['imageId' => $img->id]) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="comentarista" placeholder="Tu nombre" required>
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control" name="comentario" rows="2" placeholder="Tu comentario" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
                                </form>
                            </div>
                        </div>
            
                        <!-- Like -->
                        <form action="{{ route('like.imagen', ['imageId' => $img->id]) }}" method="POST" class="mt-3 ms-auto">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-thumbs-up me-1"></i> Me gusta 
                                @if ($img->likes)
                                    <span class="badge bg-primary">{{ $img->likes->likes }}</span>
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    
    </main>
    <footer class="footer bg-dark text-white py-4 mt-4">
        <div class="container text-center">
            <p class="mb-1">&copy; 2024 ARTNEWTON. Todos los derechos reservados.</p>
            <p class="mb-0">Síguenos en 
                <a href="#" class="text-white">Twitter</a>, 
                <a href="#" class="text-white">Facebook</a>, 
                <a href="#" class="text-white">Instagram</a>.
            </p>
        </div>
    </footer>
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Imagen Ampliada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="#" class="img-fluid rounded" alt="Imagen ampliada">
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-ZFQV5DVCn4XHbby7dOStTFUS1HIe9c4fF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener todas las imágenes de las tarjetas
            var cardImages = document.querySelectorAll('.image-card .card-img-top');
    
            // Recorrer cada imagen para agregar un evento clic
            cardImages.forEach(function(img) {
                img.addEventListener('click', function() {
                    // Obtener la ruta de la imagen
                    var imgSrc = this.getAttribute('src');
                    // Actualizar la imagen del modal con la nueva ruta
                    document.getElementById('modalImage').setAttribute('src', imgSrc);
                    // Mostrar el modal
                    var modal = new bootstrap.Modal(document.getElementById('imageModal'));
                    modal.show();
                });
            });
    
            // Obtener todos los botones "Ver comentarios"
            var showCommentButtons = document.querySelectorAll('.show-comments');
    
            // Recorrer cada botón para agregar un evento click
            showCommentButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Obtener el contenedor de comentarios
                    var commentsContainer = this.closest('.card-body').querySelector('.comments-container');
                    // Mostrar los comentarios
                    commentsContainer.classList.toggle('d-none');
    
                    // Si se muestran los comentarios, asegurarse de que se ajuste el scroll
                    if (!commentsContainer.classList.contains('d-none')) {
                        commentsContainer.scrollTop = commentsContainer.scrollHeight;
                    }
                });
            });
    
            // Ocultar todos los contenedores de comentarios al principio
            var commentsContainers = document.querySelectorAll('.comments-container');
            commentsContainers.forEach(function(container) {
                container.classList.add('d-none');
            });
    
            // Obtener todos los botones "Comentar"
            var commentButtons = document.querySelectorAll('.comment-button');
    
            // Recorrer cada botón para agregar un evento click
            commentButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Obtener el formulario de comentarios
                    var commentForm = this.closest('.card-body').querySelector('.comment-form');
                    // Mostrar el formulario de comentarios
                    commentForm.classList.toggle('d-none');
                });
            });
    
            // Función para filtrar imágenes
            function filterImages() {
                var monthFilter = document.getElementById('monthFilter').value;
                var yearFilter = document.getElementById('yearFilter').value;
                var cards = document.getElementsByClassName('image-card');
                var noImagesMessage = document.getElementById('noImagesMessage');
                var recommendation = document.getElementById('recommendation');
                var noImages = true;
    
                for (var i = 0; i < cards.length; i++) {
                    var card = cards[i];
                    var cardMonth = card.getAttribute('data-month');
                    var cardYear = card.getAttribute('data-year');
    
                    if ((monthFilter === '' || cardMonth === monthFilter) && (yearFilter === '' || cardYear === yearFilter)) {
                        card.parentElement.style.display = 'block';
                        noImages = false;
                    } else {
                        card.parentElement.style.display = 'none';
                    }
                }
    
                if (noImages) {
                    noImagesMessage.classList.remove('d-none');
                    recommendation.textContent = monthFilter === '' ? '' : 'Seleccione un mes diferente';
                } else {
                    noImagesMessage.classList.add('d-none');
                }
            }
        });
    </script>
    
</body>
</html>
