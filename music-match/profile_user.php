<?php
session_start();

// Si no está logueado, redirige al login
if (!isset($_SESSION['user_id'])) {
    header('Location: register_login.php');
    exit;
}

$host = 'localhost';
$db = 'musicmatch';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Obtener datos del usuario actual
$stmt = $pdo->prepare("SELECT u.Name, u.LastNameP, u.LastNameM, u.Email, u.PhoneNumber, l.Country, l.Region, l.City 
                       FROM User u
                       LEFT JOIN Location l ON u.IdLocation = l.IdLocation
                       WHERE u.IdUser = ?");
$stmt->execute([$_SESSION['user_id']]);
$userData = $stmt->fetch();

if (!$userData) {
    // Usuario no encontrado en BD (posible error)
    die("Usuario no encontrado.");
}

// Formatear nombre completo
$fullName = $userData['Name'] . ' ' . $userData['LastNameP'] . ' ' . $userData['LastNameM'];

// Formatear ubicación completa
$location = trim("{$userData['City']}, {$userData['Region']}, {$userData['Country']}");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Perfil de usuario en Music-Match" />
    <meta name="author" content="Music-Match" />
    <title>Music-Match | Perfil de Usuario</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        .profile-header {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid white;
            margin-top: -75px;
        }
        .profile-content {
            padding: 20px;
        }
        .social-icons a {
            margin-right: 15px;
            color: #343a40;
        }
        .social-icons a:hover {
            color: #007bff;
        }
        .action-buttons a {
            margin: 10px;
            font-size: 18px;
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
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Music-Match</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Contactanos</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalog_all.php">Musicos</a></li>
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

                <!-- Botón cerrar sesión -->
                <div class="d-flex ms-auto">
                    <a href="logout.php" class="btn btn-outline-dark">
                        <i class="bi bi-person-circle me-1"></i>
                        Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Music-Match</h1>
                <p class="lead fw-normal text-white-50 mb-0">Encuentra talento musical con solo un clic</p>
            </div>
        </div>
    </header>

    <!-- Sección de perfil de usuario -->
    <div class="container text-center">
        <!-- Foto de perfil (placeholder) -->
        <img src="https://via.placeholder.com/150" alt="Foto de perfil" class="profile-img shadow-lg">

        <!-- Información del perfil -->
        <div class="profile-content">
            <h2 class="my-3"><?= htmlspecialchars($fullName) ?></h2>
            <p class="text-muted">Ciudad: <?= htmlspecialchars($location) ?></p>
            <p class="text-muted">Correo electrónico: <?= htmlspecialchars($userData['Email']) ?></p>
            <p class="text-muted">Teléfono: <?= htmlspecialchars($userData['PhoneNumber']) ?></p>

            <!-- Descripción (puedes agregar dinámicamente si lo tienes en base de datos) -->
            <p class="mt-4">Bienvenido a tu perfil en Music-Match. Aquí podrás ver y administrar tu información personal.</p>
        </div>

        <!-- Botones de navegación -->
        <div class="action-buttons">
            <a href="musician_form.php" class="btn btn-secondary">Información Musical</a>
            <a href="purchase_history.php" class="btn btn-info">Historial de Compras</a>
        </div>

        <!-- Redes sociales -->
        <div class="social-icons my-4">
            <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
            <a href="#"><i class="fab fa-linkedin"></i> Facebook</a>
            <a href="#"><i class="fab fa-github"></i> Youtube</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
