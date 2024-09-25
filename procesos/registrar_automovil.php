<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Automóviles</title>
    <link rel="stylesheet" href="/css/registro.css">
</head>

<body>
    <div class="form-container">
        <h2>Registrar Automóvil</h2>
        <form action="procesar_registro.php" method="post">

            <label for="placa">Placa:</label>
            <input type="text" id="placa" name="placa" required>

            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" required>

            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" required>

            <label for="anio">Año:</label>
            <input type="number" id="anio" name="anio" required>

            <label for="color">Color:</label>
            <input type="text" id="color" name="color" required>

            <label for="n_motor">Número de Motor:</label>
            <input type="text" id="n_motor" name="n_motor" required>

            <label for="n_chasis">Número de Chasis:</label>
            <input type="text" id="n_chasis" name="n_chasis" required>

            <label for="t_auto">Tipo de Automóvil:</label>
            <select id="t_auto" name="t_auto" required>
                <option value="1">Sedán</option>
                <option value="2">SUV</option>
                <option value="3">Camioneta</option>
                <!-- Añade más opciones según los tipos disponibles en tu base de datos -->
            </select>

            <input type="submit" value="Registrar">
        </form>
    </div>
</body>

</html>
