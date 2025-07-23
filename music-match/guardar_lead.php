<?php
// guardar_lead.php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

if (!isset($_GET['file']) || $_GET['file'] === '') {
    die('Archivo a descargar no especificado.');
}
$file = basename($_GET['file']);

$allowedExt = ['mp3', 'wav', 'pdf', 'zip'];
$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
if (!in_array($ext, $allowedExt)) {
    die('Tipo de archivo no permitido.');
}
if (!file_exists(__DIR__ . '/descargas/' . $file)) {
    die('El archivo solicitado no existe.');
}

// Recoger datos del formulario
$nombre     = trim($_POST['name']       ?? '');
$apellidoP  = trim($_POST['lastnamep']  ?? '');
$apellidoM  = trim($_POST['lastnamem']  ?? '');
$phone      = trim($_POST['phone']      ?? '');
$email      = trim($_POST['email']      ?? '');

if ($nombre === '' || $apellidoP === '' || $apellidoM === '' || $email === '') {
    die('Nombre, apellidos y correo son obligatorios.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Correo electrónico inválido.');
}

// Conexión y lógica de inserción
try {
    $pdo = new PDO('mysql:host=localhost;dbname=MusicMatch;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buscar el IdResource correspondiente al archivo
    $query = 'SELECT IdResource FROM ResourceDownload WHERE FileName = :filename';
    $stmt = $pdo->prepare($query);
    $stmt->execute([':filename' => $file]);
    $resource = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resource) {
        die('No se encontró el recurso en la base de datos.');
    }

    $idResource = $resource['IdResource'];

    // Insertar el lead
    $sql = 'INSERT INTO Lead (Name, LastNameP, LastNameM, Email, Phone, IdResource)
            VALUES (:name, :lastnamep, :lastnamem, :email, :phone, :idresource)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name'       => $nombre,
        ':lastnamep'  => $apellidoP,
        ':lastnamem'  => $apellidoM,
        ':email'      => $email,
        ':phone'      => $phone === '' ? null : $phone,
        ':idresource' => $idResource
    ]);

} catch (PDOException $e) {
    die('Error al guardar Lead: ' . $e->getMessage());
}

// Redirigir a la descarga
header('Location: descargas/' . urlencode($file));
exit;
?>
