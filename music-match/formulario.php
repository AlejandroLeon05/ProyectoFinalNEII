<?php
// formulario.php
// Muestra un formulario para capturar los datos de un usuario antes de permitir la descarga
// ------------------------------------------------------------
// 1) Verifica que venga el parámetro ?file=...
// 2) Muestra el formulario en HTML
// 3) Al enviar, los datos van por POST a guardar_usuario.php junto con el nombre del archivo
// ------------------------------------------------------------

if (!isset($_GET['file']) || empty($_GET['file'])) {
    header("Location: index.php");
    exit;
}

$file = basename($_GET['file']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulario de descarga | Music‑Match</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Descarga exclusiva</h2>
                        <p class="text-center text-muted">Completa el formulario y obtén tu descarga.</p>

                        <!-- Formulario -->
                        <form action="guardar_lead.php?file=<?php echo urlencode($file); ?>" method="POST" novalidate>
                            <!-- Nombre -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" required />
                            </div>

                            <!-- Apellido paterno -->
                            <div class="mb-3">
                                <label for="lastnamep" class="form-label">Apellido paterno</label>
                                <input type="text" class="form-control" id="lastnamep" name="lastnamep" required />
                            </div>

                            <!-- Apellido materno -->
                            <div class="mb-3">
                                <label for="lastnamem" class="form-label">Apellido materno</label>
                                <input type="text" class="form-control" id="lastnamem" name="lastnamem" required />
                            </div>

                            <!-- Teléfono (opcional) -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="phone" name="phone" />
                            </div>

                            <!-- Correo -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required />
                            </div>

                            <!-- Botón -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Enviar y descargar</button>
                            </div>
                        </form>
                        <!-- Fin del formulario -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
