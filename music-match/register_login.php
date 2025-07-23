
<?php
// Llenar Location y Genre desde la base de datos
$pdo = new PDO("mysql:host=localhost;dbname=MusicMatch;charset=utf8mb4", "root", "");

$locations = $pdo->query("SELECT IdLocation, Country, Region, City FROM Location")->fetchAll(PDO::FETCH_ASSOC);
$genres = $pdo->query("SELECT IdGenre, Name FROM Genre")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Iniciar sesión o registrarse en Music-Match" />
    <meta name="author" content="" />
    <title>Iniciar Sesión o Registrarse - Music-Match</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-BC1H8BNL30"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-BC1H8BNL30');
</script>
</head>
<body>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success text-center">
        Registro exitoso. ¡Ahora puedes iniciar sesión!
    </div>
<?php endif; ?>

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Music-Match</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Contáctanos</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalog_all.php">Musicos</a></li>
                </ul>
                <form class="d-flex me-3" action="search.php" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Buscar músicos..." aria-label="Search" />
                    <button class="btn btn-outline-dark" type="submit">Buscar</button>
                </form>
                <a class="btn btn-outline-dark" href="cart.php">
                    <i class="bi-cart-fill me-1"></i>
                    Carrito
                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                </a>

                                    <!-- Icono de inicio de sesión -->
                                    <div class="d-flex ms-auto">
                                        <a href="profile_user.php" class="btn btn-outline-dark">
                                            <i class="bi bi-person-circle me-1"></i>
                                            Perfil de Usuario
                                        </a>
                                    </div>


            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Bienvenido a Music-Match</h1>
                <p class="lead fw-normal text-white-50 mb-0">Inicia sesión o regístrate para comenzar</p>
            </div>
        </div>
    </header>
    <!-- Login/Register Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <ul class="nav nav-tabs" id="authTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Iniciar Sesión</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Registrarse</button>
                </li>
            </ul>
            <div class="tab-content mt-4" id="authTabContent">
                <!-- Login Form -->
                <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">

                    <form action="login.php" method="POST" id="loginForm">
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="loginEmail" name="email" placeholder="nombre@ejemplo.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Iniciar Sesión</button>
                    </form>
                </div>

                <!-- Register Form -->
                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                    <form action="register.php" method="POST" id="registerForm">
    <div class="mb-3">
        <label for="registerName" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="registerName" name="name" required>
    </div>
    <div class="mb-3">
        <label for="registerLastNameP" class="form-label">Apellido Paterno</label>
        <input type="text" class="form-control" id="registerLastNameP" name="last_name_p" required>
    </div>
    <div class="mb-3">
        <label for="registerLastNameM" class="form-label">Apellido Materno</label>
        <input type="text" class="form-control" id="registerLastNameM" name="last_name_m" required>
    </div>
    <div class="mb-3">
        <label for="registerBirthDate" class="form-label">Fecha de Nacimiento</label>
        <input type="date" class="form-control" id="registerBirthDate" name="birth_date" required>
    </div>
    <div class="mb-3">
        <label for="registerEmail" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="registerEmail" name="email" required>
    </div>
    <div class="mb-3">
        <label for="registerPhone" class="form-label">Teléfono</label>
        <input type="text" class="form-control" id="registerPhone" name="phone" required>
    </div>
    <div class="mb-3">
        <label for="registerLocation" class="form-label">Ubicación</label>
        <select class="form-select" id="registerLocation" name="location" required>
            <option value="" disabled selected>Selecciona una ciudad</option>
            <!-- Aquí se llenará dinámicamente desde PHP -->
             <?php foreach ($locations as $loc): ?>
    <option value="<?= $loc['IdLocation'] ?>">
        <?= $loc['Country'] ?> - <?= $loc['Region'] ?> - <?= $loc['City'] ?>
    </option>
<?php endforeach; ?>

        </select>
    </div>
    <div class="mb-3">
        <label for="registerUserType" class="form-label">Tipo de Usuario</label>
        <select class="form-select" id="registerUserType" name="user_type" required onchange="toggleMusicianFields()">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="Client">Cliente</option>
            <option value="Musician">Músico</option>
        </select>
    </div>
    <!-- Solo visible si elige Músico -->
    <div id="musicianFields" style="display:none;">
        <div class="mb-3">
            <label for="registerGenre" class="form-label">Género Musical</label>
            <select class="form-select" id="registerGenre" name="genre">
                <option value="" disabled selected>Selecciona un género</option>
                <!-- Se llenará con PHP también -->
                 <?php foreach ($genres as $g): ?>
    <option value="<?= $g['IdGenre'] ?>"><?= $g['Name'] ?></option>
<?php endforeach; ?>

            </select>
        </div>
        <div class="mb-3">
            <label for="registerPrice" class="form-label">Precio por hora (MXN)</label>
            <input type="number" step="0.01" class="form-control" id="registerPrice" name="price_per_hour">
        </div>
        <div class="mb-3">
            <label for="registerDescription" class="form-label">Descripción del músico</label>
            <textarea class="form-control" id="registerDescription" name="description"></textarea>
        </div>
    </div>
    <div class="mb-3">
        <label for="registerPassword" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="registerPassword" name="password" required>
    </div>
    <div class="mb-3">
        <label for="registerConfirmPassword" class="form-label">Confirmar Contraseña</label>
        <input type="password" class="form-control" id="registerConfirmPassword" name="confirm_password" required>
    </div>
    <button type="submit" class="btn btn-dark w-100">Registrarse</button>
</form>

<script>
function toggleMusicianFields() {
    const userType = document.getElementById("registerUserType").value;
    const musicianFields = document.getElementById("musicianFields");
    musicianFields.style.display = (userType === "Musician") ? "block" : "none";
}
</script>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Music-Match 2024</p></div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- Custom Validation JS-->
    <script>
        function validateLoginForm() {
            const email = document.getElementById("loginEmail").value;
            const password = document.getElementById("loginPassword").value;

            if (!validateEmail(email)) {
                alert("Por favor, ingresa un correo electrónico válido.");
                return false;
            }
            if (password.length < 6) {
                alert("La contraseña debe tener al menos 6 caracteres.");
                return false;
            }
               // Si las validaciones pasan, redirigir a profileuser.html
               window.location.href = "profile_user.php";
               return false;  // Evita que el formulario haga su comportamiento por defecto
               //return true;
        }

        function validateRegisterForm() {
            const email = document.getElementById("registerEmail").value;
            const password = document.getElementById("registerPassword").value;
            const confirmPassword = document.getElementById("registerConfirmPassword").value;

            if (!validateEmail(email)) {
                alert("Por favor, ingresa un correo electrónico válido.");
                return false;
            }
            if (!validatePassword(password)) {
                alert("La contraseña debe tener al menos 6 caracteres, incluyendo una mayúscula, un número y un carácter especial.");
                return false;
            }
            if (password !== confirmPassword) {
                alert("Las contraseñas no coinciden.");
                return false;
            }
            return true;
        }

        function validateEmail(email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }

        function validatePassword(password) {
            const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
            return passwordPattern.test(password);
        }
    </script>
</body>
</html>
