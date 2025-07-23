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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .circle-rating {
            display: flex;
            direction: rtl;
        }

        .circle-rating input {
            display: none;
        }

        .circle-rating label {
            display: inline-block;
            width: 11px;
            height: 11px;
            margin-right: 5px;
            border-radius: 50%;
            background-color: #ccc;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .circle-rating input:checked+label {
            background-color: #f39c12;
        }

        .circle-rating input:checked+label~label {
            background-color: #f39c12;
        }

        .circle-rating input:not(:checked)+label {
            background-color: #ccc;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Admin Músicos</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i
                class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Buscar..." aria-label="Buscar"
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Configuración</a></li>
                    <li><a class="dropdown-item" href="#!">Registro de Actividad</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
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
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false">
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
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseClientes" aria-expanded="false">
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
                    <h1 class="mt-4">Reseñas Recientes</h1>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Buscar por Usuario o Comentario">
                        </div>
                        <div class="col">
                            <button class="btn btn-primary">Filtrar</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="reviewsChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <h4>Estadísticas de Reseñas</h4>
                            <ul>
                                <li>Total de Reseñas: 120</li>
                                <li>Aceptadas: 90</li>
                                <li>Rechazadas: 30</li>
                            </ul>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Comentario</th>
                                <th>Fecha de Publicación</th>
                                <th>Músico</th>
                                <th>Calificación</th>
                                <th>Aceptar Comentario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>JuanP</td>
                                <td>Excelente músico, muy profesional y puntual. Recomendado para cualquier evento.</td>
                                <td>2024-11-01</td>
                                <td>Gabriel C.</td>
                                <td>
                                    <div class="circle-rating">
                                        <input type="radio" id="star5-1" name="rating1" value="5">
                                        <label for="star5-1"></label>
                                        <input type="radio" id="star4-1" name="rating1" value="4">
                                        <label for="star4-1"></label>
                                        <input type="radio" id="star3-1" name="rating1" value="3">
                                        <label for="star3-1"></label>
                                        <input type="radio" id="star2-1" name="rating1" value="2">
                                        <label for="star2-1"></label>
                                        <input type="radio" id="star1-1" name="rating1" value="1">
                                        <label for="star1-1"></label>
                                    </div>
                                </td>
                                <td><input type="checkbox" id="accept1" /></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>AnaB</td>
                                <td>Muy buena experiencia, pero la calidad del sonido podría mejorar. Sin embargo, es un
                                    buen músico.</td>
                                <td>2024-11-05</td>
                                <td>Gerardo L.</td>
                                <td>
                                    <div class="circle-rating">
                                        <input type="radio" id="star5-2" name="rating2" value="5">
                                        <label for="star5-2"></label>
                                        <input type="radio" id="star4-2" name="rating2" value="4">
                                        <label for="star4-2"></label>
                                        <input type="radio" id="star3-2" name="rating2" value="3">
                                        <label for="star3-2"></label>
                                        <input type="radio" id="star2-2" name="rating2" value="2">
                                        <label for="star2-2"></label>
                                        <input type="radio" id="star1-2" name="rating2" value="1">
                                        <label for="star1-2"></label>
                                    </div>
                                </td>
                                <td><input type="checkbox" id="accept2" /></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>LuisM</td>
                                <td>Recomiendo ampliamente. Muy talentoso, puntual y fácil de trabajar. Gran desempeño.
                                </td>
                                <td>2024-11-06</td>
                                <td>Erick R.</td>
                                <td>
                                    <div class="circle-rating">
                                        <input type="radio" id="star5-3" name="rating3" value="5">
                                        <label for="star5-3"></label>
                                        <input type="radio" id="star4-3" name="rating3" value="4">
                                        <label for="star4-3"></label>
                                        <input type="radio" id="star3-3" name="rating3" value="3">
                                        <label for="star3-3"></label>
                                        <input type="radio" id="star2-3" name="rating3" value="2">
                                        <label for="star2-3"></label>
                                        <input type="radio" id="star1-3" name="rating3" value="1">
                                        <label for="star1-3"></label>
                                    </div>
                                </td>
                                <td><input type="checkbox" id="accept3" /></td>
                            </tr>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <script>
        var ctx = document.getElementById('reviewsChart').getContext('2d');
        var reviewsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Reseñas Aceptadas',
                    data: [20, 30, 10, 40, 50, 60],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>

</html>