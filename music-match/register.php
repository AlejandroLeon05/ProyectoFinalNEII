<?php
session_start();

// Conexión a la base de datos
$pdo = new PDO("mysql:host=localhost;dbname=MusicMatch;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Verifica que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger datos
    $name          = $_POST['name'] ?? '';
    $lastNameP     = $_POST['last_name_p'] ?? '';
    $lastNameM     = $_POST['last_name_m'] ?? '';
    $birthDate     = $_POST['birth_date'] ?? '';
    $email         = $_POST['email'] ?? '';
    $phone         = $_POST['phone'] ?? '';
    $idLocation    = $_POST['location'] ?? '';
    $userType      = $_POST['user_type'] ?? '';
    $password      = $_POST['password'] ?? '';
    $confirmPass   = $_POST['confirm_password'] ?? '';

    // Para músicos
    $idGenre       = $_POST['genre'] ?? null;
    $pricePerHour  = $_POST['price_per_hour'] ?? null;
    $description   = $_POST['description'] ?? null;

    // Validación básica
    if (
        empty($name) || empty($lastNameP) || empty($lastNameM) || empty($birthDate) ||
        empty($email) || empty($password) || empty($confirmPass) ||
        empty($idLocation) || empty($userType)
    ) {
        die("Todos los campos son obligatorios.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Correo no válido.");
    }

    if ($password !== $confirmPass) {
        die("Las contraseñas no coinciden.");
    }

    // Hashear contraseña
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Verificar si el correo ya existe
    $stmt = $pdo->prepare("SELECT * FROM `User` WHERE Email = ?");
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

    // Obtener ID del rol
    $stmt = $pdo->prepare("SELECT IdRole FROM Role WHERE RoleName = ?");
    $stmt->execute([$userType]);
    $idRole = $stmt->fetchColumn();

    if (!$idRole) {
        die("Rol no válido.");
    }

    // Insertar en UserRole
    $stmt = $pdo->prepare("INSERT INTO UserRole (IdUser, IdRole) VALUES (?, ?)");
    $stmt->execute([$idUser, $idRole]);

    // Si es músico, insertar en Musician
    if ($userType === "Musician") {
        if (!$idGenre || !$pricePerHour) {
            die("Faltan datos del músico.");
        }

        $stmt = $pdo->prepare("
            INSERT INTO Musician (IdUser, IdGenre, IdLocation, PricePerHour, Description, Rating)
            VALUES (?, ?, ?, ?, ?, NULL)
        ");
        $stmt->execute([
            $idUser, $idGenre, $idLocation, $pricePerHour, $description
        ]);
    }

    // Registro exitoso → redirigir al login
    header("Location: register_login.php?success=1");
    exit;
} else {
    die("Acceso inválido.");
}
