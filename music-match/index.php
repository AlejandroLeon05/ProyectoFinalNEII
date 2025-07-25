<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Music-Match</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <style>
            .card-img-top {
                height: 200px;
                object-fit: cover;
            }
            .card {
                height: 100%;
            }
        </style>
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">Contáctanos</a></li>
                        <li class="nav-item"><a class="nav-link" href="catalog_all.php">Músicos</a></li>
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
                    <h1 class="display-4 fw-bolder">Music-Match</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Encuentra talento musical con solo un clic</p>
                </div>
            </div>
        </header>
        <!-- Section-->
         <?php include 'db.php'; ?>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            $stmt = $pdo->query("
                SELECT 
                    m.IdMusician,
                    u.Name,
                    u.LastNameP,
                    u.LastNameM,
                    m.PricePerHour,
                    m.Rating
                FROM Musician m
                JOIN User u ON m.IdUser = u.IdUser
                LIMIT 8
            ");

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['IdMusician'];
                $name = htmlspecialchars($row['Name'] . ' ' . $row['LastNameP'] . ' ' . $row['LastNameM']);
                $price = $row['PricePerHour'];
                $rating = $row['Rating'];

                echo '<div class="col mb-5">
                        <div class="card h-100">
                        <a href="profile_music.php?id=' . $id . '">
                         <img class="card-img-top" src="assets/images/default_musician.jpg" alt="' . $name . '" />
                        </a>  
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h5 class="fw-bolder">' . $name . '</h5>
                                    <div class="d-flex justify-content-center small text-warning mb-2">';
                                    
                for ($i = 0; $i < floor($rating); $i++) {
                    echo '<div class="bi-star-fill"></div>';
                }

                echo '                  </div>
                                    $' . $price . '
                                </div>
                            </div>
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto add-to-cart" href="#" 
   data-id="' . $id . '" 
   data-name="' . $name . '" 
   data-price="' . $price . '">
   Agregar al carrito
</a>
                            </div>
                        </div>
                    </div>';
            }
            ?>
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
    </body>
</html>


