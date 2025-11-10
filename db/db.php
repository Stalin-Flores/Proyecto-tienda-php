<?php

$host = "localhost";
$usuario = "root";
$clave = "mysql";
$base_de_datos = "tienda";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8mb4", $usuario, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Conexión correcta
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}



?>