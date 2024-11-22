<?php
header('Content-Type: application/json');
require_once '../includes/Database.php';
require_once '../includes/Modelo.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    $modelo = new Modelo($db);
    
    if (isset($_GET['marca_id']) && is_numeric($_GET['marca_id'])) {
        $modelos = $modelo->listarPorMarca($_GET['marca_id']);
        echo json_encode($modelos);
    } else {
        echo json_encode(['error' => 'ID de marca no válido']);
    }
} catch (Exception $e) {
    error_log("Error en get_modelos.php: " . $e->getMessage());
    echo json_encode(['error' => 'Error al procesar la solicitud']);
}