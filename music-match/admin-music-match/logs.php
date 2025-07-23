<?php
session_start();

// Seguridad: solo admin puede ver esta página
if (!in_array('Admin', $_SESSION['roles'] ?? [])) {
    die("Acceso no autorizado.");
}?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Estadísticas y Bitácora de Movimientos - Plataforma de Músicos" />
    <title>Bitácora de Movimientos - Music-Match</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        /* Estilos personalizados para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #01305f;
            color: rgb(0, 0, 0);
            font-weight: bold;
        }
        table td {
            background-color: #f8f9fa;
        }
        table tr:nth-child(even) {
            background-color: #f1f1f1;
        }
        table tr:hover {
            background-color: #e2e6ea;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .table-container h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="sb-nav-fixed">
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
           <!-- Menú de usuario en la barra de navegación -->
           <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Configuración</a></li>
                    <li><a class="dropdown-item" href="#!">Registro de Actividad</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="music-match/admin_login_form.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
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
                        <a class="nav-link active" href="logs.php">
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
                    <h1 class="mt-4">Bitácora de Movimientos</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Registro de Actividades</li>
                    </ol>

                    <div class="table-container">
                        <h2>Registro de Actividades Recientes</h2>
                        <div class="table-responsive">
                            <table id="activityTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Acción</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>Admin01</td><td>Cambio de número teléfono</td><td>2024-10-01</td><td>10:30 AM</td></tr>
                                    <tr><td>Usuario02</td><td>Baja de usuario</td><td>2024-10-02</td><td>02:15 PM</td></tr>
                                    <tr><td>Admin03</td><td>Cambio de pais</td><td>2024-10-03</td><td>11:45 AM</td></tr>
                                    <tr><td>Admin01</td><td>Actualización de estado</td><td>2024-10-04</td><td>09:00 AM</td></tr>
                                    <tr><td>Usuario04</td><td>Modificación de perfil</td><td>2024-10-04</td><td>04:20 PM</td></tr>
                                    <tr><td>Usuario03</td><td>Cambio de correo email</td><td>2024-10-05</td><td>03:30 PM</td></tr>
                                    <tr><td>Admin01</td><td>Actualización de plan</td><td>2024-10-06</td><td>01:00 PM</td></tr>
                                    <tr><td>Usuario05</td><td>Reinicio de contraseña</td><td>2024-10-07</td><td>05:50 PM</td></tr>
                                    <tr><td>Admin04</td><td>Actualización de precios</td><td>2024-10-08</td><td>02:20 PM</td></tr>
                                    <tr><td>Usuario02</td><td>Visualización de Disponibilidad</td><td>2024-10-09</td><td>11:10 AM</td></tr>
                                    <tr><td>Admin03</td><td>Actualización de información</td><td>2024-10-10</td><td>10:00 AM</td></tr>
                                    <tr><td>Usuario04</td><td>Edición de perfil</td><td>2024-10-11</td><td>06:30 PM</td></tr>
                                    <tr><td>Admin02</td><td>Configuración de ordenes</td><td>2024-10-12</td><td>01:45 PM</td></tr>
                                    <tr><td>Usuario03</td><td>Consulta de estadísticas</td><td>2024-10-13</td><td>09:30 AM</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        const activityTable = document.querySelector("#activityTable");
        new simpleDatatables.DataTable(activityTable, {
            perPage: 5, // Número de filas por página
            labels: {
                placeholder: "Buscar...",
                perPage: "Entradas por página", // Modificar el texto de "entries per page"
                noRows: "No se encontraron registros",
                info: "Mostrando {start} a {end} de {rows} entradas"
            }
        });
    </script>
    
</body>
</html>
