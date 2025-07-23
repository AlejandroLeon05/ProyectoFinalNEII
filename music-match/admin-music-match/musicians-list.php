<?php
session_start();

// Seguridad: solo admin puede ver esta página
if (!in_array('Admin', $_SESSION['roles'] ?? [])) {
    die("Acceso no autorizado.");
}?>

<?php
// Conexión a la base de datos
$pdo = new PDO("mysql:host=localhost;dbname=MusicMatch;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Obtener músicos
$sql = "SELECT m.IdMusician, u.Name, u.LastNameP, u.LastNameM, u.Email, u.PhoneNumber, g.Name AS Genre, l.City, l.Region, l.Country, m.Rating
        FROM Musician m
        JOIN User u ON m.IdUser = u.IdUser
        JOIN Genre g ON m.IdGenre = g.IdGenre
        JOIN Location l ON u.IdLocation = l.IdLocation";
$musicians = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Obtener géneros
$genres = $pdo->query("SELECT * FROM Genre")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Listado de Músicos - Music-Match</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <!-- Topbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Admin Músicos</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Buscar..." aria-label="Buscar" aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" data-bs-toggle="dropdown"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Configuración</a></li>
                    <li><a class="dropdown-item" href="#">Registro de Actividad</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="admin_logout.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Principal</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Panel Principal
                        </a>
                        <div class="sb-sidenav-menu-heading">Gestión</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Músicos
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse show" id="collapseLayouts">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link active" href="musicians-list.php">Listado de Músicos</a>
                                <a class="nav-link" href="add-musician.php">Añadir Músico</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseClientes" aria-expanded="false">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>
                            Clientes
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseClientes">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="clients-list.php">Listado de Clientes</a>
                                <a class="nav-link" href="add-client.php">Añadir Cliente</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="orders.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Órdenes de Servicio
                        </a>
                        <a class="nav-link" href="Statistics.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                            Estadísticas
                        </a>
                        <a class="nav-link" href="logs.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Bitácora de Movimientos
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Conectado como:</div>
                    Admin Músicos
                </div>
            </nav>
        </div>

        <!-- Contenido principal -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Listado de Músicos</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i> Músicos Registrados
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Género</th>
                                        <th>Ubicación</th>
                                        <th>Calificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($musicians as $m): ?>
                                        <tr>
                                            <td><?= htmlspecialchars("{$m['Name']} {$m['LastNameP']} {$m['LastNameM']}") ?></td>
                                            <td><?= htmlspecialchars($m['Email']) ?></td>
                                            <td><?= htmlspecialchars($m['PhoneNumber']) ?></td>
                                            <td><?= htmlspecialchars($m['Genre']) ?></td>
                                            <td><?= htmlspecialchars("{$m['City']}, {$m['Region']}, {$m['Country']}") ?></td>
                                            <td><?= htmlspecialchars($m['Rating']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <h2 class="mt-4">Géneros Musicales</h2>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-music me-1"></i> Lista de Géneros y Nuevo Registro
                        </div>
                        <div class="card-body">
                            <ul>
                                <?php foreach ($genres as $g): ?>
                                    <li><?= htmlspecialchars($g['Name']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <form action="add-genre.php" method="POST" class="mt-3">
                                <div class="input-group">
                                    <input type="text" name="genre_name" class="form-control" placeholder="Nuevo género musical" required>
                                    <button class="btn btn-success" type="submit">Agregar Género</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Plataforma de Músicos 2023</div>
                        <div>
                            <a href="#">Política de Privacidad</a>
                            &middot;
                            <a href="#">Términos y Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
