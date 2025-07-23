<?php
session_start();

// Seguridad: solo admin puede ver esta página
if (!in_array('Admin', $_SESSION['roles'] ?? [])) {
    die("Acceso no autorizado.");
}?>
<?php


$pdo = new PDO("mysql:host=localhost;dbname=MusicMatch;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y limpiar datos
    $name       = trim($_POST['name'] ?? '');
    $lastNameP  = trim($_POST['last_name_p'] ?? '');
    $lastNameM  = trim($_POST['last_name_m'] ?? '');
    $birthDate  = $_POST['birth_date'] ?? '';
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $idLocation = $_POST['location'] ?? '';
    $password   = $_POST['password'] ?? '';
    $idGenre    = $_POST['genre'] ?? '';
    $priceHour  = $_POST['price_hour'] ?? '';
    $description= trim($_POST['description'] ?? '');

    // Validaciones básicas
    if (
        !$name || !$lastNameP || !$lastNameM || !$birthDate || !$email || !$password ||
        !$idLocation || !$idGenre || !$priceHour
    ) {
        die("Por favor completa todos los campos obligatorios.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Correo electrónico no válido.");
    }
    if (!is_numeric($priceHour) || $priceHour < 0) {
        die("La tarifa por hora debe ser un número positivo.");
    }
    $d = DateTime::createFromFormat('Y-m-d', $birthDate);
    if (!($d && $d->format('Y-m-d') === $birthDate)) {
        die("Fecha de nacimiento no válida.");
    }

    // Verificar si el correo ya existe
    $stmt = $pdo->prepare("SELECT 1 FROM `User` WHERE Email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        die("Ya existe un usuario con ese correo.");
    }

    // Hashear contraseña
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insertar en User
    $stmt = $pdo->prepare("
        INSERT INTO `User` (Name, LastNameP, LastNameM, BirthDate, Email, Password, PhoneNumber, IdLocation)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $name, $lastNameP, $lastNameM, $birthDate, $email, $hashedPassword, $phone, $idLocation
    ]);
    $idUser = $pdo->lastInsertId();

    // Insertar en Musician
    $stmt = $pdo->prepare("
        INSERT INTO Musician (IdUser, IdGenre, IdLocation, PricePerHour, Description, Rating)
        VALUES (?, ?, ?, ?, ?, NULL)
    ");
    $stmt->execute([
        $idUser, $idGenre, $idLocation, $priceHour, $description
    ]);

    // Obtener Id del rol "Musician"
    $stmt = $pdo->prepare("SELECT IdRole FROM Role WHERE RoleName = 'Musician'");
    $stmt->execute();
    $idRole = $stmt->fetchColumn();
    if (!$idRole) {
        die("No se encontró el rol de músico.");
    }

    // Insertar en UserRole
    $stmt = $pdo->prepare("INSERT INTO UserRole (IdUser, IdRole) VALUES (?, ?)");
    $stmt->execute([$idUser, $idRole]);

    // Éxito: redirigir al listado con mensaje
    echo "<script>alert('Músico registrado correctamente.'); window.location.href = 'musicians-list.php';</script>";
    exit;
} else {
    die("Acceso inválido.");
}
