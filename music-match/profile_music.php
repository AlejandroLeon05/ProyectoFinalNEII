<?php
require_once "db.php";

// Verifica si se recibió un ID válido del músico
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Músico no encontrado.";
    exit;
}

$idMusician = intval($_GET['id']);

// Consulta los datos del músico
$stmt = $pdo->prepare("
    SELECT 
        u.Name AS UserName,
        m.PricePerHour,
        m.Description AS MusicianDescription,
        m.Rating,
        g.Name AS GenreName
    FROM Musician m
    JOIN `User` u ON m.IdUser = u.IdUser
    LEFT JOIN Genre g ON m.IdGenre = g.IdGenre
    WHERE m.IdMusician = ?
");
$stmt->execute([$idMusician]);
$musician = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$musician) {
    echo "Músico no encontrado.";
    exit;
}

// Consulta el repertorio general (sin ligar a músico por ahora)
$repertoireStmt = $pdo->query("SELECT FileName, Description FROM ResourceDownload");
$resources = $repertoireStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Perfil de Músico - Music-Match</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Music-Match</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalog_all.php">Músicos</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Contáctanos</a></li>
                </ul>
                <form class="d-flex" action="search.php" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Buscar músicos...">
                    <button class="btn btn-outline-dark" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </nav>

    <header class="bg-dark text-white py-5">
        <div class="container text-center">
            <h1><?= htmlspecialchars($musician['UserName']) ?></h1>
            <p><?= htmlspecialchars($musician['GenreName']) ?></p>
        </div>
    </header>

    <main class="container my-5">
        <section>
            <h2>Descripción</h2>
            <p><?= nl2br(htmlspecialchars($musician['MusicianDescription'])) ?></p>
        </section>

        <section class="mt-4">
            <h2>Precio por Hora</h2>
            <p><strong>$<?= number_format($musician['PricePerHour'], 2) ?></strong></p>
            <p><strong>Calificación:</strong> <?= $musician['Rating'] ?>/5</p>
        </section>

        <section class="mt-5">
            <h2>Repertorio Disponible</h2>
            <?php if (count($resources) > 0): ?>
                <ul>
                    <?php foreach ($resources as $res): ?>
                        <li>
                            <?= htmlspecialchars($res['Description']) ?>
                            <a href="formulario.php?file=<?= urlencode($res['FileName']) ?>" class="btn btn-sm btn-outline-primary ms-2">Descargar</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay recursos disponibles por el momento.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            &copy; <?= date("Y") ?> Music-Match. Todos los derechos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
