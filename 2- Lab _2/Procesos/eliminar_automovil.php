<?php
include '../includes/Database.php';
include '../includes/Automovil.php';

$database = new Database();
$db = $database->getConnection();
$automovil = new Automovil($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placa'])) {
    $placa = $_POST['placa'];

    if ($automovil->eliminar($placa)) {
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
}
?>