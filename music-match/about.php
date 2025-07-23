<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Conoce más sobre Music-Match" />
    <meta name="author" content="" />
    <title>Sobre Nosotros - Music-Match</title>
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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="about.php">Contáctanos</a></li>
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
                <div class="d-flex ms-auto">
                    <a href="register_login.php" class="btn btn-outline-dark">
                        <i class="bi bi-person-circle me-1"></i>
                        Iniciar sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Conoce más sobre Music-Match</h1>
                <p class="lead fw-normal text-white-50 mb-0">Tu plataforma ideal para encontrar músicos talentosos</p>
            </div>
        </div>
    </header>
    <!-- About Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5">
                <div class="col-lg-8">
                    <h2>¿Quiénes somos?</h2>
                    <p>Music-Match es una plataforma dedicada a conectar a personas con talento musical en todos los géneros. Ya sea que busques músicos para un evento privado, una boda, una fiesta o cualquier otro tipo de celebración, en Music-Match encontrarás la opción perfecta.</p>
                    <p>Nos apasiona la música y creemos en la importancia de brindar una experiencia inolvidable a través del talento en vivo. En nuestra plataforma, podrás explorar una amplia selección de músicos, DJ, bandas y más, y encontrar lo que mejor se adapte a tu estilo y necesidades.</p>
                </div>
                <div class="col-lg-4">
                    <h2>Contacto</h2>
                    <p>¿Tienes alguna pregunta o necesitas ayuda? Contáctanos a través de nuestros canales de comunicación:</p>
                    <ul class="list-unstyled">
                        <li><strong>Teléfono:</strong> <a href="tel:+524494978951">+52 449 497 8951</a></li>
                        <li><strong>Correo electrónico:</strong> <a href="mailto:contacto@music-match.com">contacto@music-match.com</a></li>
                    </ul>
                    <h5>¡Síguenos en redes sociales!</h5>
                    <a href="#"><i class="bi bi-facebook fs-3 me-3"></i></a>
                    <a href="#"><i class="bi bi-twitter fs-3 me-3"></i></a>
                    <a href="#"><i class="bi bi-instagram fs-3 me-3"></i></a>
                    <a href="#"><i class="bi bi-youtube fs-3"></i></a>
                </div>
            </div>
        </div>
    </section>
    <div class="d-flex justify-content-center py-5">
        <div class="col-lg-6 col-md-8">
            <h2 class="text-center mb-4">Formulario de Contacto</h2>
            <div class="card shadow">
                <div class="card-body p-4">
                    <form action="process_contact.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Tu nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Tu correo electrónico" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Mensaje</label>
                            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Escribe tu mensaje aquí" required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>      
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Music-Match 2024</p></div>
    </footer> 
       <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-4f0VHp54VtI70Wyyk1J+ypI0/1DvoOXLWg/zBzFVVW4s/VOW4hj4ya40P6KN7cZ+" crossorigin="anonymous"></script>
</body>
</html>
