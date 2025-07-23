<?php
session_start();
include 'db.php';

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Debes iniciar sesión para completar la compra.'); window.location.href='register_login.php';</script>";
    exit;
}

// Verificar datos del carrito
if (!isset($_POST['cartData'])) {
    echo "<script>alert('Carrito vacío o acceso no válido.'); window.location.href='cart.php';</script>";
    exit;
}

$cart = json_decode($_POST['cartData'], true);
if (!$cart || count($cart) === 0) {
    echo "<script>alert('Tu carrito está vacío.'); window.location.href='cart.php';</script>";
    exit;
}

$userId = $_SESSION['user_id'];
$paymentMethodId = 1;  // Solo uno por ahora
$eventDate = date('Y-m-d');  // Fecha fija provisional

try {
    $pdo->beginTransaction();

    foreach ($cart as $item) {
        $idMusician = intval($item['id']);
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);
        $totalPrice = $price * $quantity;

        // Insertar en Booking
        $stmt = $pdo->prepare("INSERT INTO Booking (IdUser, IdMusician, EventDate, TotalPrice, IdPaymentMethod, Status) VALUES (?, ?, ?, ?, ?, 'Confirmed')");
        $stmt->execute([$userId, $idMusician, $eventDate, $totalPrice, $paymentMethodId]);
        
        // Opcional: Puedes guardar el IdBooking si quieres luego relacionarlo con Transaction
        // $idBooking = $pdo->lastInsertId();
    }

    $pdo->commit();

    echo "<script>
        alert('¡Compra registrada exitosamente!');
        localStorage.removeItem('cart');  // Limpia el carrito en localStorage
        window.location.href = 'index.php';
    </script>";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "<script>alert('Ocurrió un error al procesar tu compra: " . htmlspecialchars($e->getMessage()) . "'); window.location.href='cart.php';</script>";
}
