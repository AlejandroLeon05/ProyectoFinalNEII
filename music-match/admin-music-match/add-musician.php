<?php
session_start();

// Seguridad: solo admin puede ver esta página
if (!in_array('Admin', $_SESSION['roles'] ?? [])) {
    die("Acceso no autorizado.");
}?>
<?php


$pdo = new PDO("mysql:host=localhost;dbname=MusicMatch;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Cargar géneros y ubicaciones para el select
$genres = $pdo->query("SELECT IdGenre, Name FROM Genre ORDER BY Name")->fetchAll(PDO::FETCH_ASSOC);
$locations = $pdo->query("SELECT IdLocation, Country, Region, City FROM Location ORDER BY Country, Region, City")->fetchAll(PDO::FETCH_ASSOC);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y limpiar datos
    $name       = trim($_POST['name'] ?? '');
    $lastNameP  = trim($_POST['last_name_p'] ?? '');
    $lastNameM  = trim($_POST['last_name_m'] ?? '');
    $birthDate  = $_POST['birth_date'] ?? '';
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $idLocation = $_POST['location'] ?? '';
    $password   = $_POST['password'] ?? '';
    $idGenre    = $_POST['genre'] ?? '';
    $priceHour  = $_POST['price_hour'] ?? '';
    $description= trim($_POST['description'] ?? '');

    // Validaciones básicas
    if (
        !$name || !$lastNameP || !$lastNameM || !$birthDate || !$email || !$password ||
        !$idLocation || !$idGenre || !$priceHour
    ) {
        $error = "Por favor completa todos los campos obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Correo electrónico no válido.";
    } elseif (!is_numeric($priceHour) || $priceHour < 0) {
        $error = "La tarifa por hora debe ser un número positivo.";
    } else {
        // Validar fecha
        $d = DateTime::createFromFormat('Y-m-d', $birthDate);
        if (!($d && $d->format('Y-m-d') === $birthDate)) {
            $error = "Fecha de nacimiento no válida.";
        }
    }

    if (!$error) {
        try {
            // Verificar si el correo existe
            $stmt = $pdo->prepare("SELECT 1 FROM `User` WHERE Email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = "Ya existe un usuario con ese correo.";
            } else {
                // Hashear contraseña
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Insertar en User
                $stmt = $pdo->prepare("
                    INSERT INTO `User` (Name, LastNameP, LastNameM, BirthDate, Email, Password, PhoneNumber, IdLocation)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $name, $lastNameP, $lastNameM, $birthDate, $email, $hashedPassword, $phone, $idLocation
                ]);
                $idUser = $pdo->lastInsertId();

                // Insertar en Musician
                $stmt = $pdo->prepare("
                    INSERT INTO Musician (IdUser, IdGenre, IdLocation, PricePerHour, Description, Rating)
                    VALUES (?, ?, ?, ?, ?, NULL)
                ");
                $stmt->execute([
                    $idUser, $idGenre, $idLocation, $priceHour, $description
                ]);

                // Insertar rol músico
                $stmt = $pdo->prepare("SELECT IdRole FROM Role WHERE RoleName = 'Musician'");
                $stmt->execute();
                $idRole = $stmt->fetchColumn();
                if (!$idRole) throw new Exception("Rol 'Musician' no encontrado.");

                $stmt = $pdo->prepare("INSERT INTO UserRole (IdUser, IdRole) VALUES (?, ?)");
                $stmt->execute([$idUser, $idRole]);

                $success = "Músico registrado correctamente.";
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Añadir Músico - Plataforma de Músicos" />
    <title>Añadir Músico - Music-Match</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <!-- Aquí va tu navbar y sidebar igual que antes -->
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
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Configuración</a></li>
                    <li><a class="dropdown-item" href="#!">Registro de Actividad</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="admin_logout.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <!-- Sidebar idéntico al que tenías -->
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <!-- contenido del sidebar -->
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
                        <div class="collapse" id="collapseLayouts">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="musicians-list.php">Listado de Músicos</a>
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

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Añadir Músico</h1>

                    <?php if($error): ?>
                        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
                    <?php endif; ?>

                    <?php if($success): ?>
                        <div class="alert alert-success"><?=htmlspecialchars($success)?></div>
                    <?php endif; ?>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-user-plus"></i> Información del Músico
                        </div>
                        <div class="card-body">
                            <form method="POST" action="add-musician.php">
                                <!-- Datos personales del usuario -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre *</label>
                                    <input type="text" name="name" id="name" class="form-control" required value="<?=htmlspecialchars($_POST['name'] ?? '')?>">
                                </div>
                                <div class="mb-3">
                                    <label for="last_name_p" class="form-label">Apellido paterno *</label>
                                    <input type="text" name="last_name_p" id="last_name_p" class="form-control" required value="<?=htmlspecialchars($_POST['last_name_p'] ?? '')?>">
                                </div>
                                <div class="mb-3">
                                    <label for="last_name_m" class="form-label">Apellido materno *</label>
                                    <input type="text" name="last_name_m" id="last_name_m" class="form-control" required value="<?=htmlspecialchars($_POST['last_name_m'] ?? '')?>">
                                </div>
                                <div class="mb-3">
                                    <label for="birth_date" class="form-label">Fecha de nacimiento *</label>
                                    <input type="date" name="birth_date" id="birth_date" class="form-control" required value="<?=htmlspecialchars($_POST['birth_date'] ?? '')?>">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico *</label>
                                    <input type="email" name="email" id="email" class="form-control" required value="<?=htmlspecialchars($_POST['email'] ?? '')?>">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="<?=htmlspecialchars($_POST['phone'] ?? '')?>">
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Ubicación *</label>
                                    <select name="location" id="location" class="form-control" required>
                                        <option value="">Selecciona una ubicación</option>
                                        <?php foreach ($locations as $loc): ?>
                                            <option value="<?=$loc['IdLocation']?>" <?= (isset($_POST['location']) && $_POST['location'] == $loc['IdLocation']) ? 'selected' : '' ?>>
                                                <?=htmlspecialchars($loc['Country'] . " - " . $loc['Region'] . " - " . $loc['City'])?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Datos específicos del músico -->
                                <div class="mb-3">
                                    <label for="genre" class="form-label">Género musical *</label>
                                    <select name="genre" id="genre" class="form-control" required>
                                        <option value="">Selecciona un género</option>
                                        <?php foreach ($genres as $g): ?>
                                            <option value="<?=$g['IdGenre']?>" <?= (isset($_POST['genre']) && $_POST['genre'] == $g['IdGenre']) ? 'selected' : '' ?>>
                                                <?=htmlspecialchars($g['Name'])?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="price_hour" class="form-label">Tarifa por hora *</label>
                                    <input type="number" step="0.01" min="0" name="price_hour" id="price_hour" class="form-control" required value="<?=htmlspecialchars($_POST['price_hour'] ?? '')?>">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción</label>
                                    <textarea name="description" id="description" rows="3" class="form-control"><?=htmlspecialchars($_POST['description'] ?? '')?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña *</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Guardar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>

