<?php
session_start();

$host = 'localhost';
$db = 'musicmatch';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        die("Completa todos los campos.");
    }

    $stmt = $pdo->prepare("SELECT * FROM `User` WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        die("Correo o contraseña incorrectos.");
    }

    if (!password_verify($password, $user['Password'])) {
        die("Correo o contraseña incorrectos.");
    }

    $stmtRoles = $pdo->prepare("
        SELECT r.RoleName FROM Role r
        JOIN UserRole ur ON r.IdRole = ur.IdRole
        WHERE ur.IdUser = ?
    ");
    $stmtRoles->execute([$user['IdUser']]);
    $roles = $stmtRoles->fetchAll(PDO::FETCH_COLUMN);

    if (!$roles) {
        die("No tienes rol asignado.");
    }

    $_SESSION['user_id'] = $user['IdUser'];
    $_SESSION['user_name'] = $user['Name'];
    $_SESSION['roles'] = $roles;

    // Redirigir según rol
    if (in_array('Admin', $roles)) {
        header('Location: admin-music-match/index.php');
        exit;
    } elseif (in_array('Musician', $roles)) {
        header('Location: profile_user.php'); // Cambia a dashboard musico si tienes
        exit;
    } elseif (in_array('Client', $roles)) {
        header('Location: profile_user.php'); // Cambia a dashboard cliente si tienes
        exit;
    } else {
        die("Rol no reconocido.");
    }
} else {
    die("Método no permitido");
}
