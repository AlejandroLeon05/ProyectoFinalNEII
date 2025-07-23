<?php
include("db.php"); // Asegúrate de tener este archivo y que se llame así

$price = isset($_GET['price']) ? (int)$_GET['price'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;
$rating = isset($_GET['rating']) ? (int)$_GET['rating'] : null;

$sql = "
    SELECT m.IdMusician, u.Name, u.LastNameP, g.Name, m.PricePerHour, m.Description, m.Rating
    FROM Musician m
    JOIN `User` u ON m.IdUser = u.IdUser
    JOIN Genre g ON m.IdGenre = g.IdGenre
    WHERE 1=1
";

$params = [];

if ($price) {
    $sql .= " AND m.PricePerHour <= ?";
    $params[] = $price;
}
if ($type) {
    $sql .= " AND g.Name = ?";
    $params[] = $type;
}
if ($rating) {
    $sql .= " AND m.Rating >= ?";
    $params[] = $rating;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$musicians = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Filtros de Búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">Music-Match</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">Contáctanos</a></li>
                <li class="nav-item"><a class="nav-link" href="catalog_all.php">Músicos</a></li>
            </ul>
            <form class="d-flex me-3" action="search.php" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Buscar músicos...">
                <button class="btn btn-outline-dark" type="submit">Buscar</button>
            </form>
            <a class="btn btn-outline-dark" href="cart.php">
                <i class="bi bi-cart-fill me-1"></i> Carrito
            </a>
            <div class="d-flex ms-auto">
                <a href="register_login.php" class="btn btn-outline-dark">
                    <i class="bi bi-person-circle me-1"></i> Iniciar sesión
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container mt-4">
    <div class="row">
        <!-- Filtros -->
        <div class="col-md-3">
            <h5>Filtrar por:</h5>
            <form method="GET" action="search.php">
                <div class="mb-3">
                    <label for="price">Precio máximo:</label>
                    <select class="form-control" id="price" name="price">
                        <option value="">Cualquier precio</option>
                        <option value="150" <?= $price == 150 ? 'selected' : '' ?>>Hasta $150</option>
                        <option value="200" <?= $price == 200 ? 'selected' : '' ?>>Hasta $200</option>
                        <option value="250" <?= $price == 250 ? 'selected' : '' ?>>Hasta $250</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="type">Tipo:</label>
                    <select class="form-control" id="type" name="type">
                        <option value="">Cualquier tipo</option>
                        <option value="Rock" <?= $type == "Rock" ? 'selected' : '' ?>>Rock</option>
                        <option value="Banda" <?= $type == "Banda" ? 'selected' : '' ?>>Sinfonica</option>
                        <option value="Norteñas" <?= $type == "Norteñas" ? 'selected' : '' ?>>Norteño</option>
                        <option value="Mariachi" <?= $type == "Mariachi" ? 'selected' : '' ?>>Mariachi</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="rating">Calificación mínima:</label>
                    <select class="form-control" id="rating" name="rating">
                        <option value="">Cualquier calificación</option>
                        <option value="3" <?= $rating == 3 ? 'selected' : '' ?>>3 estrellas</option>
                        <option value="4" <?= $rating == 4 ? 'selected' : '' ?>>4 estrellas</option>
                        <option value="5" <?= $rating == 5 ? 'selected' : '' ?>>5 estrellas</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Aplicar Filtros</button>
            </form>
        </div>

        <!-- Resultados -->
        <div class="col-md-9">
            <h3>Resultados</h3>
            <div class="row">
                <?php if (count($musicians) > 0): ?>
                    <?php foreach ($musicians as $musician): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <a href="profile_music.php?id=<?= $musician['IdMusician'] ?>">
                                    <img src="assets/images/default.jpg" class="card-img-top" alt="Músico">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($musician['Name'] . ' ' . $musician['LastNameP']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($musician['Description']) ?></p>
                                    <p class="card-text"><strong>Género:</strong> <?= $musician['Name'] ?></p>
                                    <p class="card-text"><strong>Precio:</strong> $<?= $musician['PricePerHour'] ?>/hora</p>
                                    <p class="card-text"><strong>Calificación:</strong> <?= $musician['Rating'] ?>/5</p>
                                    <a href="profile_music.php?id=<?= $musician['IdMusician'] ?>" class="btn btn-primary">Más Información</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p>No se encontraron músicos con los filtros seleccionados.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-4">
    <div class="container">
        &copy; 2024 Music-Match. Todos los derechos reservados.
    </div>
</footer>

</body>
</html>
