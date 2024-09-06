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

// Obtener el ID del automóvil a eliminar
$automovil->placa = htmlspecialchars(strip_tags($_POST['placa']));

// Intentar eliminar el automóvil
if ($automovil->eliminarAutomovil()) {
    echo "Automóvil eliminado exitosamente.";
    
} else {
    echo "Error al eliminar el automóvil.";
}
?>
