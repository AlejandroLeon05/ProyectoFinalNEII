<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Historial de Compras" />
        <meta name="author" content="Music-Match" />
        <title>Music-Match | Historial de Compras</title>
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

        <!-- Historial de Compras -->
        <div class="container mt-5">
            <h2 class="text-center">Historial de Compras</h2>

<!-- Tabla de Historial de Compras (Contrataciones de Músicos) -->
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Músico Contratado</th>
            <th scope="col">Fecha de Contratación</th>
            <th scope="col">Método de Pago</th>
            <th scope="col">Monto Total</th>
            <th scope="col">Fecha de Pago</th>
            <th scope="col">Estado</th>
            <th scope="col">Valoración del Cliente</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Grupo Sonido Real</td>
            <td>2024-11-20</td>
            <td>Tarjeta de Crédito</td>
            <td>$1200</td>
            <td>2024-11-20</td>
            <td><span class="badge bg-success">Completado</span></td>
            <td>4/5</td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Artista X</td>
            <td>2024-11-18</td>
            <td>PayPal</td>
            <td>$1500</td>
            <td>2024-11-18</td>
            <td><span class="badge bg-warning text-dark">Pendiente</span></td>
            <td>5/5</td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td>Trío Harmónico</td>
            <td>2024-11-15</td>
            <td>Transferencia Bancaria</td>
            <td>$2000</td>
            <td>2024-11-15</td>
            <td><span class="badge bg-danger">Cancelado</span></td>
            <td>3/5</td>
        </tr>
        <tr>
            <th scope="row">4</th>
            <td>Los Sonidos del Mar</td>
            <td>2024-11-12</td>
            <td>Tarjeta de Débito</td>
            <td>$800</td>
            <td>2024-11-12</td>
            <td><span class="badge bg-success">Completado</span></td>
            <td>4/5</td>
        </tr>
        <tr>
            <th scope="row">5</th>
            <td>Orquesta Sinfónica A</td>
            <td>2024-11-10</td>
            <td>Transferencia Bancaria</td>
            <td>$2500</td>
            <td>2024-11-10</td>
            <td><span class="badge bg-success">Completado</span></td>
            <td>5/5</td>
        </tr>
        <tr>
            <th scope="row">6</th>
            <td>Voces Mágicas</td>
            <td>2024-11-08</td>
            <td>Stripe</td>
            <td>$950</td>
            <td>2024-11-08</td>
            <td><span class="badge bg-success">Completado</span></td>
            <td>3/5</td>
        </tr>
        <tr>
            <th scope="row">7</th>
            <td>Rockers Forever</td>
            <td>2024-11-06</td>
            <td>PayPal</td>
            <td>$1800</td>
            <td>2024-11-06</td>
            <td><span class="badge bg-warning text-dark">Pendiente</span></td>
            <td>4/5</td>
        </tr>
        <tr>
            <th scope="row">8</th>
            <td>Grupo Tercer Sol</td>
            <td>2024-11-02</td>
            <td>Tarjeta de Crédito</td>
            <td>$1100</td>
            <td>2024-11-02</td>
            <td><span class="badge bg-success">Completado</span></td>
            <td>5/5</td>
        </tr>
        <tr>
            <th scope="row">9</th>
            <td>Cantantes del Futuro</td>
            <td>2024-10-28</td>
            <td>Transferencia Bancaria</td>
            <td>$2100</td>
            <td>2024-10-28</td>
            <td><span class="badge bg-danger">Cancelado</span></td>
            <td>2/5</td>
        </tr>
        <tr>
            <th scope="row">10</th>
            <td>Ritmo Latino</td>
            <td>2024-10-25</td>
            <td>Stripe</td>
            <td>$1300</td>
            <td>2024-10-25</td>
            <td><span class="badge bg-success">Completado</span></td>
            <td>5/5</td>
        </tr>
    </tbody>
</table>
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

