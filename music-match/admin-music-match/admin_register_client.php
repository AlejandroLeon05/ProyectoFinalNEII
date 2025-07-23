<?php
session_start();

// Seguridad: solo admin puede ver esta página
if (!in_array('Admin', $_SESSION['roles'] ?? [])) {
    die("Acceso no autorizado.");
}?>
<?php

// Conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=localhost;dbname=MusicMatch;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Verifica que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger datos con limpieza básica
    $name        = trim($_POST['name'] ?? '');
    $lastNameP   = trim($_POST['last_name_p'] ?? '');
    $lastNameM   = trim($_POST['last_name_m'] ?? '');
    $birthDate   = $_POST['birth_date'] ?? '';
    $email       = trim($_POST['email'] ?? '');
    $phone       = trim($_POST['phone'] ?? '');
    $idLocation  = $_POST['location'] ?? '';
    $password    = $_POST['password'] ?? '';

    // Validación básica
    if (
        empty($name) || empty($lastNameP) || empty($lastNameM) ||
        empty($birthDate) || empty($email) || empty($password) || empty($idLocation)
    ) {
        die("Todos los campos son obligatorios.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Correo no válido.");
    }

    // Opcional: validar fecha con DateTime
    $d = DateTime::createFromFormat('Y-m-d', $birthDate);
    if (!($d && $d->format('Y-m-d') === $birthDate)) {
        die("Fecha de nacimiento no válida.");
    }

    // Hashear contraseña
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Verificar si el correo ya existe
        $stmt = $pdo->prepare("SELECT 1 FROM `User` WHERE Email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            die("Ya existe un usuario con ese correo.");
        }

        // Insertar en User
        $stmt = $pdo->prepare("
            INSERT INTO `User` (Name, LastNameP, LastNameM, BirthDate, Email, Password, PhoneNumber, IdLocation)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $name, $lastNameP, $lastNameM, $birthDate, $email, $hashedPassword, $phone, $idLocation
        ]);

        $idUser = $pdo->lastInsertId();

        // Obtener Id del rol "Client"
        $stmt = $pdo->prepare("SELECT IdRole FROM Role WHERE RoleName = 'Client'");
        $stmt->execute();
        $idRole = $stmt->fetchColumn();

        if (!$idRole) {
            die("No se encontró el rol de cliente.");
        }

        // Insertar en UserRole
        $stmt = $pdo->prepare("INSERT INTO UserRole (IdUser, IdRole) VALUES (?, ?)");
        $stmt->execute([$idUser, $idRole]);

        // Registro exitoso → redirigir al listado de clientes
        echo "<script>alert('Cliente registrado correctamente.'); window.location.href = 'clients-list.php';</script>";
        exit;
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
} else {
    die("Acceso inválido.");
}
