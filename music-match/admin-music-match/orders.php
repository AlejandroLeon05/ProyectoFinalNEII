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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Ordenes de Servicio | Admin - MusicMatch</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="sb-nav-fixed">
    <!-- NAVBAR SUPERIOR -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Admin MusicMatch</a>
    </nav>

    <div id="layoutSidenav">
        <!-- MENÚ LATERAL -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Panel</div>
                        <a class="nav-link" href="musicians-list.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-music"></i></div>
                            Músicos
                        </a>
                        <a class="nav-link" href="clients-list.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Clientes
                        </a>
                        <a class="nav-link active" href="orders.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                            Órdenes de Servicio
                        </a>
                        <a class="nav-link" href="statistics.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                            Estadísticas
                        </a>
                        <a class="nav-link" href="log.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Bitácora
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div id="layoutSidenav_content">
            <main class="container-fluid px-4 mt-4">
                <h1 class="mt-4">Órdenes de Servicio</h1>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-table me-1"></i> Historial de Reservas</span>
                        <div>
                            <button class="btn btn-danger btn-sm me-2" id="btnPdf"><i class="fas fa-file-pdf"></i> PDF</button>
                            <button class="btn btn-success btn-sm" id="btnCsv"><i class="fas fa-file-csv"></i> CSV</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Músico</th>
                                    <th>Fecha del Evento</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "
                                    SELECT 
                                        B.IdBooking,
                                        CONCAT(U1.Name, ' ', U1.LastNameP) AS Cliente,
                                        CONCAT(U2.Name, ' ', U2.LastNameP) AS Musico,
                                        B.EventDate,
                                        B.TotalPrice,
                                        B.Status
                                    FROM Booking B
                                    INNER JOIN `User` U1 ON B.IdUser = U1.IdUser
                                    INNER JOIN Musician M ON B.IdMusician = M.IdMusician
                                    INNER JOIN `User` U2 ON M.IdUser = U2.IdUser
                                    ORDER BY B.BookingDate DESC
                                ";
                                $result = $pdo->query($query);
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>{$row['IdBooking']}</td>";
                                    echo "<td>{$row['Cliente']}</td>";
                                    echo "<td>{$row['Musico']}</td>";
                                    echo "<td>{$row['EventDate']}</td>";
                                    echo "<td>\${$row['TotalPrice']}</td>";
                                    echo "<td><span class='badge bg-".(
                                        $row['Status'] == 'Confirmed' ? "success" : ($row['Status'] == 'Pending' ? "warning text-dark" : "danger")
                                    )."'>{$row['Status']}</span></td>";
                                    echo "<td><button 
                                    class='btn btn-outline-primary btn-sm notify-btn' 
                                    data-cliente='{$row['Cliente']}' 
                                    data-musico='{$row['Musico']}' 
                                    data-fecha='{$row['EventDate']}' 
                                    data-total='{$row['TotalPrice']}'
                                    >Notificar</button></td>";
                                    //echo "<td><button class='btn btn-outline-primary btn-sm'>Notificar</button></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid text-center">
                    <div class="small">Copyright &copy; MusicMatch 2025</div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
document.querySelectorAll('.notify-btn').forEach(button => {
    button.addEventListener('click', () => {
        const cliente = button.getAttribute('data-cliente');
        const musico = button.getAttribute('data-musico');
        const fecha = button.getAttribute('data-fecha');
        const total = button.getAttribute('data-total');

        Swal.fire({
            icon: 'success',
            title: '¡Músico Notificado!',
            html: `
                <p><strong>${musico}</strong> fue contratado por <strong>${cliente}</strong>.</p>
                <p>Fecha del evento: <strong>${fecha}</strong></p>
                <p>Total: <strong>$${total}</strong></p>
            `,
            confirmButtonText: 'Aceptar'
        });
    });
});
</script>
<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script>
document.getElementById('btnPdf').addEventListener('click', () => {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.autoTable({ html: '#datatablesSimple' });
    doc.save('ordenes.pdf');
});

document.getElementById('btnCsv').addEventListener('click', () => {
    const table = document.querySelector("#datatablesSimple");
    let csv = [];
    for (let row of table.rows) {
        let cols = Array.from(row.cells).map(cell => `"${cell.innerText}"`);
        csv.push(cols.join(","));
    }
    const blob = new Blob([csv.join("\n")], { type: 'text/csv' });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "ordenes.csv";
    link.click();
});
</script>


</body>

</html>
