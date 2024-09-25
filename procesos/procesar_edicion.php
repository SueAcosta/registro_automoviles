<?php
// Incluir la conexión a la base de datos y la clase Automovil
$projectPath = 'C:\Users\suema\Downloads\registro_automoviles';
set_include_path(get_include_path() . PATH_SEPARATOR . $projectPath);

require_once 'includes/Database.php';
require_once 'includes/Automovil.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Crear una instancia de la clase Automovil
$automovil = new Automovil($db);

// Obtener el ID del automóvil desde la URL
$placa = isset($_GET['placa']) ? htmlspecialchars(strip_tags($_GET['placa'])) : '';

// Cargar los datos del automóvil
$fila = $automovil->obtenerAutomovilPorId($placa);

if ($fila) {
    // Mostrar los datos en un formulario para que puedan ser editados
    ?>
    <form action="proceso_actualizar.php" method="POST">
        <label for="placa">Placa:</label>
        <input type="text" name="placa" value="<?php echo htmlspecialchars($fila['placa']); ?>" readonly>

        <label for="marca">Marca:</label>
        <input type="text" name="marca" value="<?php echo htmlspecialchars($fila['marca']); ?>">

        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" value="<?php echo htmlspecialchars($fila['modelo']); ?>">

        <label for="anio">Año:</label>
        <input type="number" name="anio" value="<?php echo htmlspecialchars($fila['anio']); ?>">

        <label for="color">Color:</label>
        <input type="text" name="color" value="<?php echo htmlspecialchars($fila['color']); ?>">

        <label for="n_motor">Número de Motor:</label>
        <input type="text" name="n_motor" value="<?php echo htmlspecialchars($fila['n_motor']); ?>">

        <label for="n_chasis">Número de Chasis:</label>
        <input type="text" name="n_chasis" value="<?php echo htmlspecialchars($fila['n_chasis']); ?>">

        <label for="t_auto">Tipo de Automóvil:</label>
        <select name="t_auto">
            <option value="1" <?php echo $fila['t_auto'] == '1' ? 'selected' : ''; ?>>Sedán</option>
            <option value="2" <?php echo $fila['t_auto'] == '2' ? 'selected' : ''; ?>>SUV</option>
            <option value="3" <?php echo $fila['t_auto'] == '3' ? 'selected' : ''; ?>>Camioneta</option>
            <!-- Agrega más opciones si es necesario -->
        </select>

        <button type="submit">Actualizar</button>
    </form>
<?php
} else {
    echo "No se encontró el automóvil.";
}
?>
