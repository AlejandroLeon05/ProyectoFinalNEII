<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Músicos</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <!-- Core theme CSS -->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
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
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Music-Match</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Contáctanos</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalog_all.php">Músicos</a></li>
                </ul>
                <form class="d-flex me-3" action="search.php" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Buscar músicos..."
                        aria-label="Search" />
                    <button class="btn btn-outline-dark" type="submit">Buscar</button>
                </form>
                <a class="btn btn-outline-dark" href="cart.php">
                    <i class="bi bi-cart-fill me-1"></i>
                    Carrito
                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                </a>
                <div class="d-flex ms-auto">
                    <a href="register_login.php" class="btn btn-outline-dark">
                        <i class="bi bi-person-circle me-1"></i>
                        Iniciar sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Catálogo de Músicos</h1>
            </div>
        </div>
    </header>

<?php
require_once 'db.php';

$sql = "SELECT m.IdMusician, u.Name, u.LastNameP, m.PricePerHour, m.Description, g.Name AS GenreName
        FROM Musician m
        JOIN User u ON m.IdUser = u.IdUser
        JOIN Genre g ON m.IdGenre = g.IdGenre";

$stmt = $pdo->query($sql);
$musicians = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <?php foreach ($musicians as $musician): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="profile_music.php?id=<?= $musician['IdMusician'] ?>">
                            <img src="assets/images/default_band.jpg" class="card-img-top" alt="Músico">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($musician['Name'] . ' ' . $musician['LastNameP']) ?></h5>
                            <p class="text-muted"><?= htmlspecialchars($musician['GenreName']) ?></p>
                            <p class="card-text"><?= htmlspecialchars($musician['Description']) ?></p>
                            <p class="card-text"><strong>Precio: $<?= htmlspecialchars($musician['PricePerHour']) ?>/hora</strong></p>
                            <a href="profile_music.php?id=<?= $musician['IdMusician'] ?>" class="btn btn-primary">Más Información</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


    <!-- Pie de página -->
    <footer class="bg-dark text-white text-center py-4">
        <p>Copyright &copy; Music-Match 2024</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>