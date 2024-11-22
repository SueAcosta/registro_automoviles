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

            <button type="submit"><?php echo isset($datos) ? 'Actualizar' : 'Registrar'; ?></button>
        </form>
        <a href="../index.php" class="back-link">Volver a la lista de automóviles</a>
    </div>
</body>
</html>
