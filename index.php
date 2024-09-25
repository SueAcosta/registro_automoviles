<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Automóviles</title>
    <link rel="stylesheet" href="css/diseño.css">
</head>

<body>
    <div class="container">
        <h1>Bienvenido al Sistema de Gestión de Automóviles</h1>
        <a class="btn" href="procesos/registrar_automovil.php">Registrar un nuevo automóvil</a>

        <form method="GET" action="">
            <input class="buscador" type="text" name="search" placeholder="Buscar por placa o modelo"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn" type="submit">Buscar</button>
        </form>

        <table class="tabla">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Color</th>
                    <th>Número de Motor</th>
                    <th>Número de Chasis</th>
                    <th>Tipo de Automóvil</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Incluir el archivo que contiene la conexión a la base de datos y la clase Automovil
                $projectPath = 'C:\Users\suema\Downloads\registro_automoviles';
                set_include_path(get_include_path() . PATH_SEPARATOR . $projectPath);

                require_once 'includes/Database.php';
                require_once 'includes/Automovil.php';

                // Crear una instancia de la clase Database y obtener la conexión
                $database = new Database();
                $db = $database->getConnection();

                // Crear una instancia de la clase Automovil
                $automovil = new Automovil($db);

                // Verificar si se ha enviado una búsqueda
                $searchTerm = isset($_GET['search']) ? htmlspecialchars(strip_tags($_GET['search'])) : '';

                // Consultar los datos de los automóviles, aplicando la búsqueda si se ingresó un término
                $resultado = $automovil->buscarAutomoviles($searchTerm);

                // Verificar si hay registros y mostrarlos en la tabla
                if ($resultado->rowCount() > 0) {
                    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($fila['placa']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['marca']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['modelo']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['anio']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['color']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['n_motor']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['n_chasis']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['t_auto']) . '</td>'; // Nombre del tipo de automóvil
                        echo '<td>';
                        echo '<a class="btn" href="procesos/procesar_edicion.php?placa=' . htmlspecialchars($fila['placa']) . '">Editar</a>';
                        ?>
                        <form class="b" action="procesos/proceso_eliminar.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este automóvil?');" style="display:inline;">
                            <input type="hidden" name="placa" value="<?php echo htmlspecialchars($fila['placa']); ?>">
                            <button class="btn" type="submit">Eliminar</button>
                        </form>
                        <?php
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="9">No se encontraron automóviles registrados.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <div class="footer-content">
            <p><strong>Nombre:</strong> Sue Acosta     8-1002-1727   1lS131</p>
        </div>
    </footer>

</body>

</html>
