<?php
include '../includes/Database.php';
include '../includes/Automovil.php';
require_once '../includes/marcas.php';
require_once '../includes/modelos.php';
require_once '../includes/tipovehiculo.php';

$database = new Database();
$db = $database->getConnection();
$automovil = new Automovil($db);

$automovil = new Automovil($db);
$marca = new marcas($db);
$tipoVehiculo = new tipovehiculo($db);
$modelos = new modelos($db);

// Obtener datos para los selects
$marcas = $marca->listar();
$tipos_vehiculo = $tipoVehiculo->listar();
$models = $modelos->Listar();

// Inicializar variables para mensajes
$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si la placa ya existe
    if ($automovil->verificarPlacaExistente($_POST['placa'])) {
        $mensaje = "La placa ya está registrada en el sistema.";
        $tipo_mensaje = "error";
    } else {
        // Asignar valores
        $resultado = $automovil->asignarDatos([
            'marca_id' => $_POST['marca_id'],
            'modelo_id' => $_POST['modelo_id'],
            'tipo_vehiculo_id' => $_POST['tipo_vehiculo_id'],
            'anio' => $_POST['anio'],
            'color' => $_POST['color'],
            'placa' => strtoupper($_POST['placa']),
            'numero_motor' => $_POST['numero_motor'],
            'numero_chasis' => $_POST['numero_chasis']
        ]);

        if ($resultado && $automovil->crear()) { // Cambiado de registrar() a crear()
            $_SESSION['mensaje'] = "Automovil registrado existosamente";
            $_SESSION['tipo_mensaje'] = "sucess";
            header("Location: ../index.php");
        } else {
            $mensaje = "Error al registrar el automóvil. Por favor, intente nuevamente.";
            $tipo_mensaje = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Automóvil</title>
    <link rel="stylesheet" href="../css/registro.css">
</head>
<body>
    <div class="container">
        <h2>Registrar Nuevo Automóvil</h2>
        
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
                    <?php 
        // Los valores del combo vienen de tu método listar()
        $marcas = $marca->listar();
        foreach ($marcas as $marca): ?>
            <option value="<?php echo $marca['id']; ?>">  <!-- El value será el ID -->
                <?php echo $marca['nombre']; ?>           <!-- El texto a mostrar será el nombre -->
            </option>
        <?php endforeach; ?> 
                </select>
            </div>

            <div class="form-group">
                <label for="modelo_id">Modelo:</label>
                <select id="modelo_id" name="modelo_id" required>
                    <option value="">Primero seleccione una marca</option>
                    <?php
                    $model = $modelos->listar();
        foreach ($model as $modelos): ?>
            <option value="<?php echo $modelos['id']; ?>">  <!-- El value será el ID -->
                <?php echo $modelos['nombre']; ?>           <!-- El texto a mostrar será el nombre -->
            </option>
        <?php endforeach; ?> 
                </select>
            </div>

            <div class="form-group">
                <label for="tipo_vehiculo_id">Tipo de Vehículo:</label>
                <select id="tipo_vehiculo_id" name="tipo_vehiculo_id" required>
                    <option value="">Seleccione un tipo</option>
                    <?php
                    $tip = $tipoVehiculo->listar();
        foreach ($tip as $tipoVehiculo): ?>
            <option value="<?php echo $tipoVehiculo['id']; ?>">  <!-- El value será el ID -->
                <?php echo $tipoVehiculo['nombre']; ?>           <!-- El texto a mostrar será el nombre -->
            </option>
        <?php endforeach; ?> 
                </select>
            </div>

            <div class="form-group">
                <label for="anio">Año:</label>
                <input type="number" id="anio" name="anio" required 
                       min="1900" max="<?php echo date('Y') + 1; ?>" 
                       value="<?php echo date('Y'); ?>">
            </div>

            <div class="form-group">
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" required 
                       pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                       title="Solo letras y espacios">
            </div>

            <div class="form-group">
                <label for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" required 
                       pattern="[A-Za-z0-9-]+" 
                       title="Solo letras, números y guiones"
                       style="text-transform: uppercase;">
            </div>

            <div class="form-group">
                <label for="numero_motor">Número de Motor:</label>
                <input type="text" id="numero_motor" name="numero_motor" required 
                       pattern="[A-Za-z0-9-]+" 
                       title="Solo letras, números y guiones">
            </div>

            <div class="form-group">
                <label for="numero_chasis">Número de Chasis:</label>
                <input type="text" id="numero_chasis" name="numero_chasis" required 
                       pattern="[A-Za-z0-9-]+" 
                       title="Solo letras, números y guiones">
            </div>

            <button type="submit">Registrar Automóvil</button>
        </form>
        <a href="../index.php" class="back-link">Volver al listado</a>
    </div>

    <script>

    function validarFormulario() {
        // Validar que se haya seleccionado una marca
        if (!document.getElementById('marca_id').value) {
            alert('Por favor seleccione una marca');
            return false;
        }
        
        // Validar que se haya seleccionado un modelo
        if (!document.getElementById('modelo_id').value) {
            alert('Por favor seleccione un modelo');
            return false;
        }
        
        // Validar que se haya seleccionado un tipo de vehículo
        if (!document.getElementById('tipo_vehiculo_id').value) {
            alert('Por favor seleccione un tipo de vehículo');
            return false;
        }
        
        return true;
    }

    // Agregar evento cuando el documento esté listo
    document.addEventListener('DOMContentLoaded', function() {
        // Si hay una marca seleccionada al cargar la página, cargar sus modelos
        const marca_select = document.getElementById('marca_id');
        if (marca_select.value) {
            cargarModelos();
        }
    });
    </script>
</body>
</html>