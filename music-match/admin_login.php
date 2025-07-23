<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        die("Faltan datos.");
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=MusicMatch;charset=utf8mb4", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Buscar al usuario por correo
        $stmt = $pdo->prepare("SELECT * FROM `User` WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("Usuario no encontrado.");
        }

        // Verificar contraseña
        if (!password_verify($password, $user['Password'])) {
            die("Contraseña incorrecta.");
        }

        // Obtener todos los roles del usuario
        $stmt = $pdo->prepare("
            SELECT R.RoleName
            FROM UserRole UR
            JOIN Role R ON UR.IdRole = R.IdRole
            WHERE UR.IdUser = ?
        ");
        $stmt->execute([$user['IdUser']]);
        $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (!in_array('Admin', $roles)) {
            die("Acceso denegado. No eres administrador.");
        }

        // Guardar datos de sesión
        $_SESSION['admin_id'] = $user['IdUser'];
        $_SESSION['admin_email'] = $user['Email'];
        $_SESSION['roles'] = $roles; // ahora sí guarda los roles

        // Redirigir al panel admin
        header("Location: admin-music-match/index.php");
        exit;

    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
}
?>
