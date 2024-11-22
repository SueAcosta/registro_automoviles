<?php
// Incluir todos los archivos necesarios
require_once '../includes/Database.php';
require_once '../includes/Automovil.php';
require_once '../includes/Marca.php';
require_once '../includes/Modelo.php';
require_once '../includes/TipoVehiculo.php';

try {
    // Crear instancia de la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Crear instancia de Automovil
    $automovil = new Automovil($db);

    // Verificar que todos los campos necesarios estén presentes
    $campos_requeridos = ['marca_id', 'modelo_id', 'tipo_vehiculo_id', 'anio', 'color', 'placa', 'numero_motor', 'numero_chasis'];
    foreach ($campos_requeridos as $campo) {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            throw new Exception("El campo {$campo} es requerido.");
        }
    }

    // Verificar si la placa ya existe
    if ($automovil->verificarPlacaExistente($_POST['placa'])) {
        throw new Exception("La placa ya está registrada en el sistema.");
    }

    // Preparar los datos para el registro
    $datos = [
        'marca_id' => intval($_POST['marca_id']),
        'modelo_id' => intval($_POST['modelo_id']),
        'tipo_vehiculo_id' => intval($_POST['tipo_vehiculo_id']),
        'anio' => intval($_POST['anio']),
        'color' => htmlspecialchars(strip_tags($_POST['color'])),
        'placa' => strtoupper(htmlspecialchars(strip_tags($_POST['placa']))),
        'numero_motor' => htmlspecialchars(strip_tags($_POST['numero_motor'])),
        'numero_chasis' => htmlspecialchars(strip_tags($_POST['numero_chasis']))
    ];

    // Asignar los datos al objeto automóvil
    if (!$automovil->asignarDatos($datos)) {
        throw new Exception("Error al asignar los datos del vehículo.");
    }

    // Intentar crear el registro
    if ($automovil->crear()) {
        // Registro exitoso
        echo json_encode([
            'status' => 'success',
            'message' => 'Vehículo registrado exitosamente',
            'redirect' => '../index.php'
        ]);
    } else {
        throw new Exception("Error al registrar el vehículo en la base de datos.");
    }

} catch (Exception $e) {
    // Log del error
    error_log("Error en procesar_registro.php: " . $e->getMessage());
    
    // Respuesta de error
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>