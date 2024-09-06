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

$automovil->placa = htmlspecialchars(strip_tags($_POST['placa']));
$automovil->marca = htmlspecialchars(strip_tags($_POST['marca']));
$automovil->modelo = htmlspecialchars(strip_tags($_POST['modelo']));
$automovil->anio = htmlspecialchars(strip_tags($_POST['anio']));
$automovil->color = htmlspecialchars(strip_tags($_POST['color']));


// Actualizar los datos del automóvil
if ($automovil->actualizarAutomovil()) {
    echo "se actualizo corre";
    // Redirigir al index o mostrar mensaje
} else {
    echo "Error al actualizar el automóvil.";
}
?>
