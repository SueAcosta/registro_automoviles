<?php
header('Content-Type: application/json');
include '../includes/Database.php';
include '../includes/Automovil.php';

$database = new Database();
$db = $database->getConnection();
$automovil = new Automovil($db);

if (isset($_GET['marca_id'])) {
    $marca_id = $_GET['marca_id'];
    
    try {
        $query = "SELECT id, nombre FROM modelos WHERE marca_id = :marca_id ORDER BY nombre";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':marca_id', $marca_id);
        $stmt->execute();
        
        $modelos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($modelos);
    } catch(PDOException $e) {
        echo json_encode(['error' => 'Error al obtener los modelos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'ID de marca no proporcionado']);
}?>