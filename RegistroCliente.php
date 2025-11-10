<?php
include 'db/db.php';
session_start();

// Consultar tipos de identificación
$sql = $conexion->query("SELECT * FROM tipo_identificacion");
$tipos_ide = $sql->fetchAll(PDO::FETCH_ASSOC);

// Capturar datos del formulario
$nombre = trim($_POST['nombre'] ?? '');
$numero_identificacion = trim($_POST['numero_identificacion'] ?? '');
$cod_tipo_ide = trim($_POST['tipo_identificacion'] ?? '');

// Registrar nuevo cliente
if (isset($_POST['btnRegistrar'])) {

    if ($nombre != '' && $numero_identificacion != '' && $cod_tipo_ide != '') {

        $stmt = $conexion->prepare("INSERT INTO cliente (nombre, numero_identificacion, cod_tipo_ide) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $numero_identificacion, $cod_tipo_ide]);

        $_SESSION['cliente_agregado'] = true;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Consultar clientes con su tipo de identificación
$resultado = $conexion->query("SELECT c.*, t.tipo_identificacion FROM cliente c 
LEFT JOIN tipo_identificacion t ON c.cod_tipo_ide = t.cod_tipo_ide");
$consulta = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software Tienda</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!--  AGREGADO PARA DATATABLES -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row">

        <!-- FORMULARIO -->
        <div class="col-md-4">
            <div class="card shadow border-primary">
                <div class="card-header text-center bg-primary text-white">
                    <h4><i class="bi bi-person-plus"></i> Registrar Cliente</h4>
                </div>

                <div class="card-body">

                    <form action="" method="POST">

                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-person"></i> Nombre del Cliente</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Juan Pérez" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-card-list"></i> Tipo de Identificación</label>
                            <select class="form-select" name="tipo_identificacion" required>
                                <option selected disabled>Selecciona un tipo</option>
                                <?php foreach ($tipos_ide as $fila): ?>
                                    <option value="<?= $fila['cod_tipo_ide'] ?>"><?= $fila['tipo_identificacion'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-hash"></i> Número de Identificación</label>
                            <input type="number" class="form-control" name="numero_identificacion" placeholder="72548963" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" name="btnRegistrar">
                            <i class="bi bi-save"></i> Registrar
                        </button>

                    </form>

                </div>
            </div>
        </div>

        <!-- TABLA -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4><i class="bi bi-table"></i> Lista de Clientes</h4>
                </div>

                <div class="card-body table-responsive">

                    <!--  AGREGAMOS ID PARA DATATABLES -->
                    <table id="tablaClientes" class="table table-hover table-bordered text-center align-middle">
                        <thead class="table-primary">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Tipo Identificación</th>
                            <th>Número</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($consulta as $fila): ?>
                            <tr>
                                <td><?= $fila['cod_cliente'] ?></td>
                                <td><?= $fila['nombre'] ?></td>
                                <td><?= $fila['tipo_identificacion'] ?></td>
                                <td><?= $fila['numero_identificacion'] ?></td>
                                <td>

                                    <a href="actualizar/actualizar.php?cod_cliente=<?= $fila['cod_cliente'] ?>" class="btn btn-success btn-sm">
                                        <i class="bi bi-pencil-square">Editar</i>
                                    </a>

                                    <form action="./eliminar/eliminar.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="cod_cliente" value="<?= $fila['cod_cliente'] ?>">
                                        <button type="button" onclick="confirmarEliminar(this.form)" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash3">Eliminar</i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

</div>

<script>
function confirmarEliminar(form) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esta acción",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>

<?php
if (isset($_SESSION['cliente_agregado'])) {
    echo "<script>Swal.fire('Excelente','Cliente agregado correctamente','success')</script>";
    unset($_SESSION['cliente_agregado']);
}
if (isset($_SESSION['cliente_actualizado'])) {
    echo "<script>Swal.fire('Listo','Cliente actualizado correctamente','success')</script>";
    unset($_SESSION['cliente_actualizado']);
}
if (isset($_SESSION['cliente_eliminado'])) {
    echo "<script>Swal.fire('Eliminado','Cliente eliminado correctamente','success')</script>";
    unset($_SESSION['cliente_eliminado']);
}
?>

<!-- 👉 SCRIPTS DE DATATABLES -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
// 👉 ACTIVAMOS DATATABLES
$(document).ready(function() {
    $('#tablaClientes').DataTable({
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });
});
</script>

</body>
</html>
