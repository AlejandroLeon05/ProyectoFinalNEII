<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Formulario de Información Musical" />
        <meta name="author" content="Music-Match" />
        <title>Music-Match | Información Musical</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-BC1H8BNL30"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-BC1H8BNL30');
</script>
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php">Music-Match</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">Contáctanos</a></li>
                        <li class="nav-item"><a class="nav-link" href="catalog_all.php">Músicos</a></li>
                    </ul>
                    <form class="d-flex me-3" action="search.php" method="GET">
                        <input class="form-control me-2" type="search" name="query" placeholder="Buscar músicos..." aria-label="Search" />
                        <button class="btn btn-outline-dark" type="submit">Buscar</button>
                    </form>
                    <a class="btn btn-outline-dark" href="cart.php">
                        <i class="bi-cart-fill me-1"></i>
                        Carrito
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </a>
                    <div class="d-flex ms-auto">
                        <a href="profile_user.php" class="btn btn-outline-dark">
                            <i class="bi bi-person-circle me-1"></i>
                            Perfil de Usuario 
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Formulario de Información Musical -->
        <div class="container mt-5">
            <h2 class="text-center">Información Musical</h2>
            <form>
                <!-- Información de la agrupación -->
                <div class="form-group">
                    <label for="bandName">Nombre de la Agrupación</label>
                    <input type="text" class="form-control" id="bandName" placeholder="Nombre de la agrupación">
                </div>
                <div class="form-group">
                    <label for="genre">Género Musical</label>
                    <input type="text" class="form-control" id="genre" placeholder="Género musical">
                </div>

                <!-- Subir fotos -->
                <div class="form-group">
                    <label for="bandPhoto">Foto de la Agrupación</label>
                    <input type="file" class="form-control" id="bandPhoto">
                </div>

                <!-- Información de Paquetes -->
                <div class="form-group">
                    <label for="promotionPackage">Selecciona un Paquete de Promoción</label>
                    <select class="form-control" id="promotionPackage">
                        <option>Paquete Básico</option>
                        <option>Paquete Intermedio</option>
                        <option>Paquete Premium</option>
                    </select>
                </div>

                <!-- Cargar Canciones -->
                <div class="form-group">
                    <label for="songFiles">Sube tus Canciones</label>
                    <input type="file" class="form-control" id="songFiles" multiple>
                </div>

                <!-- Precios -->
                <div class="form-group">
                    <label for="price">Precio por Presentación</label>
                    <input type="number" class="form-control" id="price" placeholder="Ingresa el precio por presentación">
                </div>

                <div>
                <!-- Botón de Enviar -->
                <button type="submit" class="btn btn-primary btn-block">Guardar Información</button>
                </div>
            </form>
        </div>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Music-Match 2024</p></div>
        </footer>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
