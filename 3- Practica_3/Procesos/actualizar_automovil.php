<?php
include '../includes/Database.php';
include '../includes/Automovil.php';

$database = new Database();
$db = $database->getConnection();
$automovil = new Automovil($db);

// Inicializar variables
$datos = [];
$mensaje = '';
$tipo_mensaje = '';

// Obtener listas para los selects
$marcas = $automovil->obtenerMarcas();
$tipos_vehiculo = $automovil->obtenerTiposVehiculo();

// Buscar automóvil por placa
if (isset($_GET['placa'])) {
    $placa = $_GET['placa'];
    $datos = $automovil->buscarPorPlaca($placa);
    if ($datos) {
        $datos = $datos[0];
        // Obtener modelos de la marca seleccionada
        $modelos = $automovil->obtenerModelosPorMarca($datos['marca_id']);
    } else {
        echo "Automóvil no encontrado.";
        exit;
    }
}

// Procesar formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos_actualizacion = [
        'marca_id' => $_POST['marca_id'],
        'modelo_id' => $_POST['modelo_id'],
        'tipo_vehiculo_id' => $_POST['tipo_vehiculo_id'],
        'anio' => $_POST['anio'],
        'color' => $_POST['color'],
        'placa' => $_POST['placa'],
        'numero_motor' => $_POST['numero_motor'],
        'numero_chasis' => $_POST['numero_chasis']
    ];

    if ($automovil->asignarDatos($datos_actualizacion) && $automovil->actualizar()) {
        echo "<script>
            alert('Actualización realizada exitosamente.');
            window.location.href = '../index.php';
        </script>";
    } else {
        $mensaje = "Error al actualizar el automóvil.";
        $tipo_mensaje = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Automóvil</title>
    <link rel="stylesheet" href="../css/registro.css">
</head>
<body>
<div class="form-container">
    <h1>Actualizar Automóvil</h1>
    
    <?php if ($mensaje): ?>
        <div class="mensaje <?php echo $tipo_mensaje; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="" onsubmit="return validarFormulario()">
        <div class="form-group">
            <label for="marca_id">Marca:</label>
            <select id="marca_id" name="marca_id" required onchange="cargarModelos()">
                <option value="">Seleccione una marca</option>
                <?php foreach ($marcas as $marca): ?>
                    <option value="<?php echo $marca['id']; ?>" 
                            <?php echo (isset($datos['marca_id']) && $datos['marca_id'] == $marca['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($marca['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="modelo_id">Modelo:</label>
            <select id="modelo_id" name="modelo_id" required>
                <option value="">Primero seleccione una marca</option>
                <?php if (isset($modelos)): ?>
                    <?php foreach ($modelos as $modelo): ?>
                        <option value="<?php echo $modelo['id']; ?>"
                                <?php echo (isset($datos['modelo_id']) && $datos['modelo_id'] == $modelo['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($modelo['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="tipo_vehiculo_id">Tipo de Vehículo:</label>
            <select id="tipo_vehiculo_id" name="tipo_vehiculo_id" required>
                <option value="">Seleccione un tipo</option>
                <?php foreach ($tipos_vehiculo as $tipo): ?>
                    <option value="<?php echo $tipo['id']; ?>"
                            <?php echo (isset($datos['tipo_vehiculo_id']) && $datos['tipo_vehiculo_id'] == $tipo['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($tipo['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="anio">Año:</label>
            <input type="number" id="anio" name="anio" required 
                   min="1900" max="<?php echo date('Y') + 1; ?>"
                   value="<?php echo isset($datos['anio']) ? htmlspecialchars($datos['anio']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="color">Color:</label>
            <input type="text" id="color" name="color" required 
                   value="<?php echo isset($datos['color']) ? htmlspecialchars($datos['color']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="placa">Placa:</label>
            <input type="text" id="placa" name="placa" readonly 
                   value="<?php echo isset($datos['placa']) ? htmlspecialchars($datos['placa']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="numero_motor">Número de Motor:</label>
            <input type="text" id="numero_motor" name="numero_motor" required 
                   value="<?php echo isset($datos['numero_motor']) ? htmlspecialchars($datos['numero_motor']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="numero_chasis">Número de Chasis:</label>
            <input type="text" id="numero_chasis" name="numero_chasis" required 
                   value="<?php echo isset($datos['numero_chasis']) ? htmlspecialchars($datos['numero_chasis']) : ''; ?>">
        </div>

        <button type="submit">Actualizar</button>
    </form>
    <a href="../index.php" class="back-link">Volver al listado</a>
</div>

<script>
function cargarModelos() {
    const marca_id = document.getElementById('marca_id').value;
    const modelo_select = document.getElementById('modelo_id');
    
    // Limpiar select de modelos
    modelo_select.innerHTML = '<option value="">Seleccione un modelo</option>';
    
    if (marca_id) {
        fetch(`../Procesos/get_modelos.php?marca_id=${marca_id}`)
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    data.forEach(modelo => {
                        const option = document.createElement('option');
                        option.value = modelo.id;
                        option.textContent = modelo.nombre;
                        modelo_select.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                modelo_select.innerHTML = '<option value="">Error al cargar modelos</option>';
            });
    }
}

function validarFormulario() {
    // Validar marca
    if (!document.getElementById('marca_id').value) {
        alert('Por favor seleccione una marca');
        return false;
    }
    
    // Validar modelo
    if (!document.getElementById('modelo_id').value) {
        alert('Por favor seleccione un modelo');
        return false;
    }
    
    // Validar tipo de vehículo
    if (!document.getElementById('tipo_vehiculo_id').value) {
        alert('Por favor seleccione un tipo de vehículo');
        return false;
    }
    
    return true;
}
</script>
</body>
</html>