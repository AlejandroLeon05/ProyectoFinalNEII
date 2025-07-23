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
        <style>
            #chartContainer {
                height: 300px;
                width: 100%;
            }
            #monthlyIncomeChart {
                width: 100%;
                height: 100%;
            }
        </style>
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
                        <h1 class="mt-4">Ingresos del mes</h1>
        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Filtrar Ingresos
                            </div>
                            <div class="card-body">
                                <div class="filter d-flex justify-content-between mb-3">
                                    <div>
                                        <label for="month">Mes:</label>
                                        <select id="month" class="form-select">
                                            
                                            <option value="01">Enero</option>
                                            <option value="02">Febrero</option>
                                            <option value="03">Marzo</option>
                                            <option value="04">Abril</option>
                                            <option value="05">Mayo</option>
                                            <option value="06">Junio</option>
                                            <option value="07">Julio</option>
                                            <option value="08">Agosto</option>
                                            <option value="09">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                            
                                        </select>
                                    </div>
                                    <div>
                                        <label for="year">Año:</label>
                                        <select id="year" class="form-select">
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary" onclick="filtrarIngresos()">Ver Ingresos</button>
                                    <button class="btn btn-secondary" onclick="mostrarTodosLosRegistros()">Ver Todos</button>
                                </div>
        
                                <table id="datatablesSimple" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nombre del Músico</th>
                                            <th>Servicio</th>
                                            <th>Fecha de Registro</th>
                                            <th>Ingreso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr data-fecha="2024-11"><td>Juan Pérez</td><td>Músico</td><td>01/11/2024</td><td>$300</td></tr>
                                        <tr data-fecha="2024-11"><td>Ana López</td><td>Músico</td><td>05/11/2024</td><td>$500</td></tr>
                                        <tr data-fecha="2024-10"><td>Mario Ruiz</td><td>Músico</td><td>15/10/2024</td><td>$300</td></tr>
                                        <tr data-fecha="2023-11"><td>Lucía Vega</td><td>Músico</td><td>20/11/2023</td><td>$450</td></tr>
                                        <tr data-fecha="2023-10"><td>Sara Mora</td><td>Músico</td><td>30/10/2023</td><td>$320</td></tr>
                                        <tr data-fecha="2024-09"><td>Pablo Sánchez</td><td>Músico</td><td>10/09/2024</td><td>$600</td></tr>
                                        <tr data-fecha="2024-01"><td>Robeto Martinez</td><td>Músico</td><td>09/01/2024</td><td>$500</td></tr>
                                        <tr data-fecha="2024-10"><td>Alejandra Diaz</td><td>Músico</td><td>10/01/2024</td><td>$300</td></tr>
                                        <tr data-fecha="2024-02"><td>Saul Sanchez</td><td>Músico</td><td>14/02/2024</td><td>$400</td></tr>
                                        <tr data-fecha="2024-03"><td>Gabriel Corona</td><td>Músico</td><td>19/03/2024</td><td>$600</td></tr>
                                        <tr data-fecha="2024-04"><td>Gerardo López</td><td>Músico</td><td>20/04/2024</td><td>$500</td></tr>
                                        <tr data-fecha="2024-05"><td>David Rodriguez</td><td>Músico</td><td>27/05/2024</td><td>$200</td></tr>
                                        <tr data-fecha="2024-06"><td>Christian Medina</td><td>Músico</td><td>03/06/2024</td><td>$350</td></tr>
                                        <tr data-fecha="2024-07"><td>Fernando Salas</td><td>Músico</td><td>15/07/2024</td><td>$450</td></tr>
                                        <tr data-fecha="2024-08"><td>Alex Moreno</td><td>Músico</td><td>11/08/2024</td><td>$500</td></tr>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total Ingresos:</strong></td>
                                            <td id="totalIngresos">$0</td>
                                        </tr>
                                    </tfoot>
                                </table>
    
                                <div id="chartContainer">
                                    <canvas id="monthlyIncomeChart"></canvas>
                                </div>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        function filtrarIngresos() {
            let mes = document.getElementById("month").value;
            let year = document.getElementById("year").value;
            let rows = document.querySelectorAll("#datatablesSimple tbody tr");
            let totalIngresos = 0;
            let ingresosPorMusico = {};

            rows.forEach(row => {
                let fecha = row.getAttribute("data-fecha");
                
                if (fecha.includes(year) && fecha.includes(mes)) {
                    row.style.display = "";
                    let ingreso = parseInt(row.cells[3].innerText.replace('$', ''));
                    let musico = row.cells[0].innerText;

                    ingresosPorMusico[musico] = (ingresosPorMusico[musico] || 0) + ingreso;

                    totalIngresos += ingreso;
                } else {
                    row.style.display = "none";
                }
            });
            document.getElementById("totalIngresos").innerText = `$${totalIngresos}`;

            crearGraficaIngresos(ingresosPorMusico);
        }

        function crearGraficaIngresos(data) {
            if (window.incomeChart) {
                window.incomeChart.destroy();
            }

            let labels = Object.keys(data);
            let ingresos = Object.values(data);

            let ctx = document.getElementById('monthlyIncomeChart').getContext('2d');
            window.incomeChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ingresos ($)',
                        data: ingresos,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function mostrarTodosLosRegistros() {
    let rows = document.querySelectorAll("#datatablesSimple tbody tr");

    rows.forEach(row => {
        row.style.display = "";
    });

    let totalIngresos = 0;
    let ingresosPorMusico = {};

    rows.forEach(row => {
        let ingreso = parseInt(row.cells[3].innerText.replace('$', ''));
        let musico = row.cells[0].innerText;

        ingresosPorMusico[musico] = (ingresosPorMusico[musico] || 0) + ingreso;

        totalIngresos += ingreso;
    });

    document.getElementById("totalIngresos").innerText = `$${totalIngresos}`;

    crearGraficaIngresos(ingresosPorMusico);
}
    </script>
</body>
</html>