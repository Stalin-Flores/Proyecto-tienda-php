<?php 
session_start();
include '../db/db.php';

// Obtener el código del cliente desde la URL (parámetro GET)
$cod = $_GET['cod_cliente'] ?? '';

// Validar que se reciba el código del cliente
if (empty($cod)) {
    die("Error: No se especificó el cliente a editar");
}

// Obtener todos los tipos de identificación disponibles para mostrar en el select
$sql = $conexion->query("SELECT * FROM tipo_identificacion");
$tipos_ide = $sql->fetchAll(PDO::FETCH_ASSOC);

// Obtener los datos del cliente específico que se va a editar
$stmt_cliente = $conexion->prepare("SELECT * FROM cliente WHERE cod_cliente = ?");
$stmt_cliente->execute([$cod]);
$cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);

// Verificar que el cliente existe en la base de datos
if (!$cliente) {
    die("Error: Cliente no encontrado");
}

// Validar y procesar el formulario
if (isset($_POST['btnActualizar'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $numero_identificacion = trim($_POST['numero_identificacion'] ?? '');
    $cod_tipo_ide = trim($_POST['tipo_identificacion'] ?? '');
    
    if ($nombre != '' && $numero_identificacion != '' && $cod_tipo_ide != '') {

        $actualizar = $conexion->prepare("UPDATE cliente SET nombre=?, numero_identificacion=?, cod_tipo_ide=? WHERE cod_cliente=?");
        $actualizar->execute([$nombre, $numero_identificacion, $cod_tipo_ide, $cod]);

        $_SESSION['cliente_actualizado'] = true;
        header("Location: ../RegistroCliente.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente - Software Tienda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header text-center bg-primary text-white rounded-top-4">
                        <h4 class="mb-0">
                            <i class="bi bi-pencil-square"></i> Editar Cliente
                        </h4>
                    </div>

                    <div class="card-body p-4">

                        <form action="" method="POST">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person-circle"></i> Nombre del Cliente
                                </label>
                                <input type="text" class="form-control form-control-lg" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-card-list"></i> Tipo de Identificación
                                </label>
                                <select class="form-select form-select-lg" name="tipo_identificacion" required>
                                    <option disabled>Selecciona un tipo</option>
                                    <?php foreach ($tipos_ide as $fila): ?>
                                        <option value="<?php echo $fila['cod_tipo_ide']; ?>" 
                                            <?php echo ($fila['cod_tipo_ide'] == $cliente['cod_tipo_ide']) ? 'selected' : ''; ?>>
                                            <?php echo $fila['tipo_identificacion']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-hash"></i> Número de Identificación
                                </label>
                                <input type="number" class="form-control form-control-lg" name="numero_identificacion" value="<?php echo htmlspecialchars($cliente['numero_identificacion']); ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-2" name="btnActualizar">
                                <i class="bi bi-check-circle-fill"></i> Guardar Cambios
                            </button>

                            <a href="../RegistroCliente.php" class="btn btn-outline-secondary btn-lg w-100">
                                <i class="bi bi-arrow-left-circle"></i> Cancelar y Volver
                            </a>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
