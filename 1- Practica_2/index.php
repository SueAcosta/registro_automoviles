<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Automóviles</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <h1>Bienvenido al Sistema de Gestión de Automóviles</h1>
    <form action="" method="GET">
        <label for="buscarPlaca">Buscar por placa:</label>
        <input type="text" id="buscarPlaca" name="placa" required>
        <button type="submit">Buscar</button>
    </form>
    <a href="View/registrar_automovil.php">Registrar un nuevo automóvil</a>
    <h2>Lista de Automóviles</h2>
    <table>
        <thead>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Color</th>
                <th>Placa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Incluir conexión y clase Automovil
            include 'includes/Database.php';
            include 'includes/Automovil.php';

            $database = new Database();
            $db = $database->getConnection();
            $automovil = new Automovil($db);

            if (isset($_GET['placa']) && !empty($_GET['placa'])) {
                $placa = $_GET['placa'];
                $resultados = $automovil->buscarPorPlaca($placa);
            } else {
                $resultados = $automovil->obtenerTodos();
            }


            if ($resultados) {
                foreach ($resultados as $fila) {
                    echo "<tr>
                            <td>{$fila['marca']}</td>
                            <td>{$fila['modelo']}</td>
                            <td>{$fila['anio']}</td>
                            <td>{$fila['color']}</td>
                            <td>{$fila['placa']}</td>
                            <td>
                                <form method='POST' action='Procesos/eliminar_automovil.php' style='display:inline;'>
                                    <input type='hidden' name='placa' value='{$fila['placa']}'>
                                    <button type='submit'>Eliminar</button>
                                </form>
                                <form method='GET' action='Procesos/actualizar_automovil.php' style='display:inline;'>
                                    <input type='hidden' name='placa' value='{$fila['placa']}'>
                                    <button type='submit'>Actualizar</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No se encontraron automóviles.</td></tr>";
            }
            ?>
        </tbody>
    </table>



</body>
<footer class="footer">
    <div class="footer-content">
        <p>&copy; <?php echo date('Y'); ?> - Desarrollado por: Sue Acosta</p>
        <p>Cedula: 8-1002-1727 | Grupo:1LS131</p>
        
    </div>
</footer>
</html>
