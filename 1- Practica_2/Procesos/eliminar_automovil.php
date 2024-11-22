<?php
include '../includes/Database.php';
include '../includes/Automovil.php';

$database = new Database();
$db = $database->getConnection();
$automovil = new Automovil($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placa'])) {
    $placa = $_POST['placa'];
    if ($automovil->eliminar($placa)) {
        echo "Automóvil eliminado correctamente.";
    } else {
        echo "Error al eliminar el automóvil.";
    }
}
header("../index.php");
exit;
?>
