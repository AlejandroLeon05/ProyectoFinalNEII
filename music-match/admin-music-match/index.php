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
        <meta name="description" content="Panel de Administración - Plataforma de Músicos" />
        <title>Panel de Administración - Music-Match</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Marca de la barra de navegación -->
            <a class="navbar-brand ps-3" href="index.php">Admin Músicos</a>
            <!-- Botón para alternar el menú lateral -->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <!-- Búsqueda en la barra de navegación -->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Buscar..." aria-label="Buscar" aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Menú de usuario en la barra de navegación -->
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
                            <!-- Sección de Clientes -->
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
                        <h1 class="mt-4">Panel Principal</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Resumen</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Músicos Registrados</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="musicians-list.php">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Órdenes Pendientes</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="orders.php">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Ingresos del Mes</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="Ingreso_del_mes.php">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Reseñas Recientes</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="Reseñas_Recientes.php">Ver Detalles</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Gráfico de Productos Más Vendidos -->
                            <div class="col-xl-6 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Productos Más Vendidos
                                    </div>
                                    <div class="card-body">
                                        <canvas id="productsSoldChart" width="100%" height="40"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- Gráfico de Usuarios Más Activos -->
                            <div class="col-xl-6 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-users me-1"></i>
                                        Usuarios Más Activos
                                    </div>
                                    <div class="card-body">
                                        <canvas id="activeUsersChart" width="100%" height="40"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                    <!--Seccion de tabla de musicos -->
                        <div class="container-fluid px-4">
                            <h3 class="mt-4">Listado de Músicos</h3>
                            <!-- Tabla de Músicos -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Tabla de Músicos
                                </div>
                                <div class="card-body">
                                    <!-- Tabla de Músicos -->
                                    <table id="musiciansTable" class="table table-striped table-bordered">
                                    <!--    -->
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Género Musical</th>
                                                <th>Precio por Hora</th>
                                                <th>Descripción</th>
                                                <th>País</th>
                                                <th>Estado</th>
                                                <th>Ciudad</th>
                                                <th>Disponibilidad</th>
                                                <th>Rating</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Ejemplo de filas -->
                                            <tr>
                                                <td>Juan Pérez</td>
                                                <td>Rock</td>
                                                <td>$50</td>
                                                <td>Guitarrista profesional</td>
                                                <td>México</td>
                                                <td>Aguascalientes</td>
                                                <td>Aguascalientes</td>
                                                <td>Disponible</td>
                                                <td>4.8</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Juan Pérez</td>
                                                <td>Rock</td>
                                                <td>$50</td>
                                                <td>Guitarrista profesional</td>
                                                <td>México</td>
                                                <td>Aguascalientes</td>
                                                <td>Aguascalientes</td>
                                                <td>Disponible</td>
                                                <td>4.8</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Mario Gómez</td>
                                                <td>Pop</td>
                                                <td>$60</td>
                                                <td>Cantante y compositor</td>
                                                <td>Colombia</td>
                                                <td>Medellín</td>
                                                <td>Medellín</td>
                                                <td>Disponible</td>
                                                <td>4.7</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Lucía Fernández</td>
                                                <td>Jazz</td>
                                                <td>$70</td>
                                                <td>Saxofonista</td>
                                                <td>Argentina</td>
                                                <td>Buenos Aires</td>
                                                <td>Buenos Aires</td>
                                                <td>Disponible</td>
                                                <td>4.9</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Carlos Martínez</td>
                                                <td>Clásica</td>
                                                <td>$80</td>
                                                <td>Pianista</td>
                                                <td>España</td>
                                                <td>Madrid</td>
                                                <td>Madrid</td>
                                                <td>Disponible</td>
                                                <td>5.0</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Andrés López</td>
                                                <td>Reggaetón</td>
                                                <td>$55</td>
                                                <td>DJ y productor</td>
                                                <td>Puerto Rico</td>
                                                <td>San Juan</td>
                                                <td>San Juan</td>
                                                <td>Disponible</td>
                                                <td>4.6</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>María Ruiz</td>
                                                <td>Flamenco</td>
                                                <td>$75</td>
                                                <td>Cantante y guitarrista</td>
                                                <td>España</td>
                                                <td>Sevilla</td>
                                                <td>Sevilla</td>
                                                <td>Disponible</td>
                                                <td>4.8</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Diego Rodríguez</td>
                                                <td>Blues</td>
                                                <td>$65</td>
                                                <td>Guitarrista y vocalista</td>
                                                <td>Estados Unidos</td>
                                                <td>Chicago</td>
                                                <td>Chicago</td>
                                                <td>Disponible</td>
                                                <td>4.7</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Roberta Vargas</td>
                                                <td>Reggaetón</td>
                                                <td>$50</td>
                                                <td>Cantante</td>
                                                <td>República Dominicana</td>
                                                <td>Santo Domingo</td>
                                                <td>Santo Domingo</td>
                                                <td>Disponible</td>
                                                <td>4.6</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Felipe García</td>
                                                <td>Electrónica</td>
                                                <td>$90</td>
                                                <td>DJ y productor</td>
                                                <td>Chile</td>
                                                <td>Santiago</td>
                                                <td>Santiago</td>
                                                <td>Disponible</td>
                                                <td>4.9</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Valentina López</td>
                                                <td>Cumbia</td>
                                                <td>$40</td>
                                                <td>Cantante y bailarina</td>
                                                <td>Perú</td>
                                                <td>Lima</td>
                                                <td>Lima</td>
                                                <td>Disponible</td>
                                                <td>4.5</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tomás Hernández</td>
                                                <td>Trap</td>
                                                <td>$60</td>
                                                <td>Rapper y compositor</td>
                                                <td>Puerto Rico</td>
                                                <td>Bayamón</td>
                                                <td>Bayamón</td>
                                                <td>Disponible</td>
                                                <td>4.7</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Gabriela Sánchez</td>
                                                <td>Pop</td>
                                                <td>$55</td>
                                                <td>Cantante</td>
                                                <td>Argentina</td>
                                                <td>Córdoba</td>
                                                <td>Córdoba</td>
                                                <td>Disponible</td>
                                                <td>4.6</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Esteban Rodríguez</td>
                                                <td>Rock</td>
                                                <td>$50</td>
                                                <td>Bajista</td>
                                                <td>Chile</td>
                                                <td>Valparaíso</td>
                                                <td>Valparaíso</td>
                                                <td>Disponible</td>
                                                <td>4.8</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Javier García</td>
                                                <td>Jazz</td>
                                                <td>$80</td>
                                                <td>Contrabajista</td>
                                                <td>Colombia</td>
                                                <td>Cali</td>
                                                <td>Cali</td>
                                                <td>Disponible</td>
                                                <td>5.0</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Susana Morales</td>
                                                <td>Flamenco</td>
                                                <td>$65</td>
                                                <td>Cantante flamenca</td>
                                                <td>España</td>
                                                <td>Granada</td>
                                                <td>Granada</td>
                                                <td>Disponible</td>
                                                <td>4.7</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Editar</button>
                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Plataforma de Músicos 2024</div>
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
        <script>
            const musiciansTable = document.querySelector("#musiciansTable");
            new simpleDatatables.DataTable(musiciansTable, {
                perPage: 5, // Número de filas por página
                labels: {
                    placeholder: "Buscar...",
                    perPage: "Entradas por página", // Modificar el texto de "entries per page"
                    noRows: "No se encontraron registros",
                    info: "Mostrando {start} a {end} de {rows} entradas"
                }
            });
        </script>
        <script>
            // Gráfico de Productos Más Vendidos
            var ctx1 = document.getElementById('productsSoldChart').getContext('2d');
            var productsSoldChart = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Djs', 'Solistas', 'Banda', 'Trios', 'Mariachi'],
                    datasets: [{
                        label: 'Cantidad Vendida',
                        data: [120, 150, 180, 100, 90],
                        backgroundColor: 'rgba(0, 123, 255, 0.5)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }]
                }
            });

            // Gráfico de Usuarios Más Activos
            var ctx4 = document.getElementById('activeUsersChart').getContext('2d');
            var activeUsersChart = new Chart(ctx4, {
                type: 'line',
                data: {
                    labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
                    datasets: [{
                        label: 'Usuarios Activos',
                        data: [120, 150, 200, 250],
                        borderColor: '#007bff',
                        fill: false,
                        borderWidth: 2
                    }]
                }
            });
        </script>
    </body>
</html>