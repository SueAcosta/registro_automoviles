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
        <form method="POST" action="../Procesos/procesar_registro.php">
    <label for="marca">Marca:</label>
    <input type="text" id="marca" name="marca" required>

    <label for="modelo">Modelo:</label>
    <input type="text" id="modelo" name="modelo" required>

    <label for="anio">Año:</label>
    <input type="number" id="anio" name="anio" required>

    <label for="color">Color:</label>
    <input type="text" id="color" name="color" required>

    <label for="placa">Placa:</label>
    <input type="text" id="placa" name="placa" required>

    <!-- Nuevos campos -->
    <label for="numero_motor">Número de Motor:</label>
    <input type="text" id="numero_motor" name="numero_motor" required>

    <label for="numero_chasis">Número de Chasis:</label>
    <input type="text" id="numero_chasis" name="numero_chasis" required>

    <label for="tipo_vehiculo">Tipo de Vehículo:</label>
    <select id="tipo_vehiculo" name="tipo_vehiculo" required>
        <option value="Motocicleta">Motocicleta</option>
        <option value="Hatchback">Hatchback</option>
        <option value="Sedan">Sedan</option>
        <option value="Camioneta">Camioneta</option>
        <option value="Microbús">Microbús</option>
    </select>

    <button type="submit">Registrar</button>

        <a href="../index.php" class="back-link">Volver a la lista de automóviles</a>
    </div>
</body>
</html>
