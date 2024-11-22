<?php
// Incluir archivos de conexión y clase Automovil
include '../includes/Database.php';
include '../includes/Automovil.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Crear una instancia de la clase Automovil
$automovil = new Automovil($db);

// Obtener la placa de la solicitud
$placa = $_GET['placa'];

// Buscar el automóvil por placa
$resultado = $automovil->buscarPorPlaca($placa);

// Mostrar el resultado en una tabla
if ($resultado) {
    echo "<h2>Resultado de búsqueda:</h2>";
    echo "<table>
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Color</th>
                    <th>Placa</th>
                     <th>N° de Motor</th>
                      <th>N° de Chasis</th>
                       <th>Tipo de Vehiculo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$resultado['marca']}</td>
                    <td>{$resultado['modelo']}</td>
                    <td>{$resultado['anio']}</td>
                    <td>{$resultado['color']}</td>
                    <td>{$resultado['placa']}</td>
                      <td>{$resultado['numero_motor']}</td>
                        <td>{$resultado['numero_chasis']}</td>
                          <td>{$resultado['tipo_vehiculo']}</td>
                </tr>
            </tbody>
          </table>";
} else {
    echo "<p>No se encontró un automóvil con la placa proporcionada.</p>";
}
?>