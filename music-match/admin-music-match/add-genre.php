<?php
session_start();

// Seguridad: solo admin puede ver esta página
if (!in_array('Admin', $_SESSION['roles'] ?? [])) {
    die("Acceso no autorizado.");
}?>

<?php
// Conexión a la base de datos
$pdo = new PDO("mysql:host=localhost;dbname=MusicMatch;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Validar que se recibió el nombre del género
if (isset($_POST['genre_name']) && !empty(trim($_POST['genre_name']))) {
    $genreName = trim($_POST['genre_name']);

    // Verificar si el género ya existe
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Genre WHERE Name = ?");
    $stmt->execute([$genreName]);
    $exists = $stmt->fetchColumn();

    if ($exists == 0) {
        // Insertar nuevo género
        $insert = $pdo->prepare("INSERT INTO Genre (Name) VALUES (?)");
        $insert->execute([$genreName]);
    }

    // Redirigir de vuelta
    header("Location: musicians-list.php");
    exit;
} else {
    // Si no se recibió un nombre válido, redirige sin hacer nada
    header("Location: musicians-list.php");
    exit;
}
