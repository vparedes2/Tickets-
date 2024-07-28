<?php
// Cargar variables de entorno si no están ya cargadas
if (!function_exists('getenv')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_DATABASE') ?: 'crm-gestion';
$user = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';

// Determinar si estamos en Render
$isRender = getenv('RENDER') === 'true';

if ($isRender) {
    // Configuración para Render (PostgreSQL)
    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
} else {
    // Configuración local (MySQL)
    $con = mysqli_connect($host, $user, $password, $dbname);
    if (mysqli_connect_errno()) {
        die("Connection Fail: " . mysqli_connect_error());
    }
}
