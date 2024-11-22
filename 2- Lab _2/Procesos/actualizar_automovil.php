<?php
include '../includes/Database.php';
include '../includes/Automovil.php';

$database = new Database();
$db = $database->getConnection();
$automovil = new Automovil($db);
// Inicializar $datos como un arreglo vacío por defecto
$datos = [];

if (isset($_GET['placa'])) {
    $placa = $_GET['placa'];
    $datos = $automovil->buscarPorPlaca($placa);
    if ($datos) {
        $datos = $datos[0];
    } else {
        echo "Automóvil no encontrado.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asignar correctamente todos los valores
    $automovil->marca = $_POST['marca'];
    $automovil->modelo = $_POST['modelo'];
    $automovil->anio = $_POST['anio'];
    $automovil->color = $_POST['color'];
    $automovil->placa = $_POST['placa'];
    $automovil->numero_motor = $_POST['numero_motor'];     // Corregido
    $automovil->numero_chasis = $_POST['numero_chasis'];   // Corregido
    $automovil->tipo_vehiculo = $_POST['tipo_vehiculo'];  // Corregido

    // Registrar automóvil
    if ($automovil->actualizar()) {
        echo "<script>
            alert('Actualización realizada exitosamente.');
            window.location.href = '../index.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al actualizar el automóvil. Intente nuevamente.');
            window.location.href = '../index.php';
        </script>";
    }
}
?>

<!-- El resto del código HTML permanece igual -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Automóvil</title>
    <link rel="stylesheet" href="../css/registro.css">
</head>
<body>
<div class="form-container">
        <h1><?php echo isset($datos) ? 'Actualizar Automóvil' : 'Registrar Automóvil'; ?></h1>
        <form method="POST">
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" 
                value="<?php echo isset($datos['marca']) ? $datos['marca'] : ''; ?>" required>

            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" 
                value="<?php echo isset($datos['modelo']) ? $datos['modelo'] : ''; ?>" required>

            <label for="anio">Año:</label>
            <input type="number" id="anio" name="anio" 
                value="<?php echo isset($datos['anio']) ? $datos['anio'] : ''; ?>" required>

            <label for="color">Color:</label>
            <input type="text" id="color" name="color" 
                value="<?php echo isset($datos['color']) ? $datos['color'] : ''; ?>" required>

            <?php if (isset($datos)) { ?>
                <label for="placa">Placa (No editable):</label>
                <input type="text" id="placa" name="placa" value="<?php echo $datos['placa']; ?>" readonly>
            <?php } else { ?>
                <label for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" placeholder="Ej. ABC123" required>
            <?php } ?>

            <label for="numero_motor">Número de Motor:</label>
    <input type="text" id="numero_motor" name="numero_motor" value="<?php echo isset($datos['numero_motor']) ? $datos['numero_motor'] : ''; ?>" required>

    <label for="numero_chasis">Número de Chasis:</label>
    <input type="text" id="numero_chasis" name="numero_chasis" value="<?php echo isset($datos['numero_chasis']) ? $datos['numero_chasis'] : ''; ?>" required>

    <label for="tipo_vehiculo">Tipo de Vehículo:</label>
    <select id="tipo_vehiculo" name="tipo_vehiculo" required>
        <option value="Motocicleta" <?php echo isset($datos['tipo_vehiculo']) && $datos['tipo_vehiculo'] == 'Motocicleta' ? 'selected' : ''; ?>>Motocicleta</option>
        <option value="Hatchback" <?php echo isset($datos['tipo_vehiculo']) && $datos['tipo_vehiculo'] == 'Hatchback' ? 'selected' : ''; ?>>Hatchback</option>
        <option value="Sedan" <?php echo isset($datos['tipo_vehiculo']) && $datos['tipo_vehiculo'] == 'Sedan' ? 'selected' : ''; ?>>Sedan</option>
        <option value="Camioneta" <?php echo isset($datos['tipo_vehiculo']) && $datos['tipo_vehiculo'] == 'Camioneta' ? 'selected' : ''; ?>>Camioneta</option>
        <option value="Microbús" <?php echo isset($datos['tipo_vehiculo']) && $datos['tipo_vehiculo'] == 'Microbús' ? 'selected' : ''; ?>>Microbús</option>
    </select>

            <button type="submit"><?php echo isset($datos) ? 'Actualizar' : 'Registrar'; ?></button>
        </form>
        <a href="../index.php" class="back-link">Volver a la lista de automóviles</a>
    </div>
</body>
</html>
