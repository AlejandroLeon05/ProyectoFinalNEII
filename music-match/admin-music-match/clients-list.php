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

// Obtener todos los usuarios con rol Cliente
$stmt = $pdo->query("
    SELECT U.Name, U.Email, U.PhoneNumber, L.City, L.Region, L.Country
    FROM User U
    JOIN UserRole UR ON UR.IdUser = U.IdUser
    JOIN Role R ON R.IdRole = UR.IdRole
    JOIN Location L ON L.IdLocation = U.IdLocation
    WHERE R.RoleName = 'Client'
");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Clientes - Music-Match Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">

<!-- NAVBAR SUPERIOR -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.php">Music-Match Admin</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
</nav>

<!-- LAYOUT -->
<div id="layoutSidenav">
    <!-- MENU LATERAL -->
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Inicio
                    </a>
                    <a class="nav-link" href="musicians-list.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-music"></i></div>
                        Músicos
                    </a>
                    <a class="nav-link active" href="clients-list.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Clientes
                    </a>
                    <a class="nav-link" href="orders-list.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                        Órdenes de Servicio
                    </a>
                    <a class="nav-link" href="stats.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                        Estadísticas
                    </a>
                    <a class="nav-link" href="logs.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                        Bitácora
                    </a>
                    <a class="nav-link" href="admin_logout.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                        Cerrar Sesión
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div id="layoutSidenav_content">
        <main class="container-fluid px-4">
            <h1 class="mt-4">Listado de Clientes</h1>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-users me-1"></i>
                    Clientes registrados en la plataforma
                </div>
                <div class="card-body">
                    <table id="clientsTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Ciudad</th>
                                <th>Región</th>
                                <th>País</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><?= htmlspecialchars($client['Name']) ?></td>
                                    <td><?= htmlspecialchars($client['Email']) ?></td>
                                    <td><?= htmlspecialchars($client['PhoneNumber']) ?></td>
                                    <td><?= htmlspecialchars($client['City']) ?></td>
                                    <td><?= htmlspecialchars($client['Region']) ?></td>
                                    <td><?= htmlspecialchars($client['Country']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">Editar</button>
                                        <button class="btn btn-sm btn-danger">Eliminar</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid text-muted text-center">
                &copy; Music-Match 2024. Todos los derechos reservados.
            </div>
        </footer>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
<script>
    const table = document.querySelector("#clientsTable");
    new simpleDatatables.DataTable(table, {
        perPage: 5,
        labels: {
            placeholder: "Buscar...",
            perPage: "Mostrar {select} entradas por página",
            noRows: "No hay registros",
            info: "Mostrando {start} a {end} de {rows} registros"
        }
    });
</script>
</body>
</html>
