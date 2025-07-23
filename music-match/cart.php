<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Music-Match - Carrito</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa; 
        }

        main {
            flex: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }

        table {
            width: 100%;
            max-width: 800px; 
            background-color: #ffffff; 
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            text-align: center;
        }

        .total {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 20px;
            color: #000; 
        }

        .btn-danger {
            background-color: #dc3545; 
            border: none; 
        }

        .btn-danger:hover {
            background-color: #c82333; 
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Music-Match</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Contáctanos</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalog_all.php">Músicos</a></li>
                </ul>

                <form class="d-flex me-3" action="search.php" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Buscar músicos..." />
                    <button class="btn btn-outline-dark" type="submit">Buscar</button>
                </form>

                <a class="btn btn-outline-dark" href="cart.php">
                    <i class="bi-cart-fill me-1"></i>
                    Carrito
                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                </a>

                <div class="d-flex ms-auto">
                    <a href="register_login.php" class="btn btn-outline-dark">
                        <i class="bi bi-person-circle me-1"></i> Iniciar sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Carrito de Compras</h1>
            </div>
        </div>
    </header>

    <main>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Músico</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <!-- Se rellena con JavaScript -->
            </tbody>
        </table>

        <div class="total">
            Total a pagar: $<span id="cart-total">0.00</span>
        </div>

        <!-- Botón para continuar a checkout -->
        <form action="checkout.php" method="POST" onsubmit="return sendCartData();">
            <input type="hidden" name="cartData" id="cartData">
            <button type="submit" class="btn btn-primary mt-3">Contratar Músico</button>
        </form>
    </main>

    <footer class="py-5 bg-dark mt-auto">
        <div class="container text-center text-white">Copyright &copy; Music-Match 2024</div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            function renderCart() {
                const container = document.getElementById('cart-items');
                container.innerHTML = '';

                let total = 0;

                cart.forEach((item, index) => {
                    const subtotal = item.price * item.quantity;
                    total += subtotal;

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>$${item.price.toFixed(2)}</td>
                        <td>${item.quantity}</td>
                        <td>$${subtotal.toFixed(2)}</td>
                        <td><button class="btn btn-danger btn-sm" data-index="${index}">Eliminar</button></td>
                    `;
                    container.appendChild(row);
                });

                document.getElementById('cart-total').textContent = total.toFixed(2);

                // Eliminar del carrito
                document.querySelectorAll('.btn-danger').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const index = e.target.getAttribute('data-index');
                        cart.splice(index, 1);
                        localStorage.setItem('cart', JSON.stringify(cart));
                        renderCart();
                        updateCartBadge();
                    });
                });
            }

            function updateCartBadge() {
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                const badge = document.querySelector('.badge');
                if (badge) badge.textContent = totalItems;
            }

            renderCart();
            updateCartBadge();
        });

        function sendCartData() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            document.getElementById('cartData').value = JSON.stringify(cart);
            return true;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
