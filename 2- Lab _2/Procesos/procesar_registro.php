<?php
// Incluir archivos de conexión y clase Automovil
include '../includes/Database.php';
include '../includes/Automovil.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Crear una instancia de la clase Automovil
$automovil = new Automovil($db);


// Obtener datos del formulario
$automovil->marca = $_POST['marca'];
$automovil->modelo = $_POST['modelo'];
$automovil->anio = $_POST['anio'];
$automovil->color = $_POST['color'];
$automovil->placa = $_POST['placa'];
$automovil->numero_motor = $_POST['numero_motor'];
$automovil->numero_chasis = $_POST['numero_chasis'];
$automovil->tipo_vehiculo = $_POST['tipo_vehiculo'];

// Registrar automóvil
if ($automovil->registrar()) {
      // Registrar automóvil
      
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
?>