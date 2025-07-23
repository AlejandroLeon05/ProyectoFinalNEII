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

// Ingresos por mes
$incomeQuery = $pdo->query("
    SELECT DATE_FORMAT(EventDate, '%M') AS MonthName, SUM(TotalPrice) AS Income
    FROM Booking
    WHERE Status = 'Confirmed'
    GROUP BY MONTH(EventDate)
    ORDER BY MONTH(EventDate)
");
$months = [];
$incomes = [];
foreach ($incomeQuery as $row) {
    $months[] = $row['MonthName'];
    $incomes[] = $row['Income'];
}

// Estado de las reservas
$statusQuery = $pdo->query("
    SELECT Status, COUNT(*) AS Count
    FROM Booking
    GROUP BY Status
");
$statusLabels = [];
$statusCounts = [];
foreach ($statusQuery as $row) {
    $statusLabels[] = $row['Status'];
    $statusCounts[] = $row['Count'];
}

// Métodos de pago
$paymentQuery = $pdo->query("
    SELECT PM.MethodName, COUNT(*) AS Count
    FROM Booking B
    JOIN PaymentMethod PM ON B.IdPaymentMethod = PM.IdPaymentMethod
    GROUP BY B.IdPaymentMethod
");
$paymentLabels = [];
$paymentCounts = [];
foreach ($paymentQuery as $row) {
    $paymentLabels[] = $row['MethodName'];
    $paymentCounts[] = $row['Count'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Estadísticas - Music-Match Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <a class="nav-link" href="clients-list.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Clientes
                    </a>
                    <a class="nav-link" href="orders.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                        Órdenes de Servicio
                    </a>
                    <a class="nav-link active" href="statistics.php">
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
            <h1 class="mt-4">Estadísticas</h1>

            <!-- INGRESOS POR MES -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-dollar-sign me-1"></i>Ingresos por mes</div>
                <div class="card-body"><canvas id="incomeChart"></canvas></div>
            </div>

            <!-- ESTADOS DE RESERVA -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-tasks me-1"></i>Estado de las reservas</div>
                <div class="card-body"><canvas id="statusChart"></canvas></div>
            </div>

            <!-- MÉTODOS DE PAGO -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-credit-card me-1"></i>Métodos de pago usados</div>
                <div class="card-body"><canvas id="paymentMethodChart"></canvas></div>
            </div>
        </main>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid text-center text-muted">
                &copy; Music-Match 2024. Todos los derechos reservados.
            </div>
        </footer>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>

<script>
    // Ingresos por mes
    const incomeChart = new Chart(document.getElementById("incomeChart"), {
        type: "line",
        data: {
            labels: <?= json_encode($months) ?>,
            datasets: [{
                label: "Ingresos ($)",
                data: <?= json_encode($incomes) ?>,
                borderColor: "#28a745",
                backgroundColor: "rgba(40,167,69,0.1)",
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true
        }
    });

    // Estado de las reservas
    const statusChart = new Chart(document.getElementById("statusChart"), {
        type: "doughnut",
        data: {
            labels: <?= json_encode($statusLabels) ?>,
            datasets: [{
                data: <?= json_encode($statusCounts) ?>,
                backgroundColor: ["#28a745", "#ffc107", "#dc3545"]
            }]
        },
        options: {
            responsive: true
        }
    });

    // Métodos de pago
    const paymentMethodChart = new Chart(document.getElementById("paymentMethodChart"), {
        type: "bar",
        data: {
            labels: <?= json_encode($paymentLabels) ?>,
            datasets: [{
                label: "Usos",
                data: <?= json_encode($paymentCounts) ?>,
                backgroundColor: "rgba(0,123,255,0.5)",
                borderColor: "rgba(0,123,255,1)",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

</body>
</html>
