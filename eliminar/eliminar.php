<?php
include '../db/db.php';  

if (isset($_POST['cod_cliente'])) {
    $cod_cliente = $_POST['cod_cliente'];

    $stmt = $conexion->prepare("DELETE FROM cliente WHERE cod_cliente = ?");
    $stmt->execute([$cod_cliente]);

    session_start();
    $_SESSION['cliente_eliminado'] = true;

    header("Location: ../RegistroCliente.php");
    exit;
} else {
    echo "Código no recibido";
}
