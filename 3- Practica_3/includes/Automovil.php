<?php
class Automovil {
    private $conn;
    private $table_name = "automoviles";

    public $id;
    public $marca_id;
    public $modelo_id;
    public $tipo_vehiculo_id;
    public $anio;
    public $color;
    public $placa;
    public $numero_motor;
    public $numero_chasis;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . "
                (marca_id, modelo_id, tipo_vehiculo_id, anio, color, placa, numero_motor, numero_chasis)
                VALUES
                (:marca_id, :modelo_id, :tipo_vehiculo_id, :anio, :color, :placa, :numero_motor, :numero_chasis)";

        try {
            $stmt = $this->conn->prepare($query);

            // Limpiar y vincular datos
            $stmt->bindParam(":marca_id", $this->marca_id);
            $stmt->bindParam(":modelo_id", $this->modelo_id);
            $stmt->bindParam(":tipo_vehiculo_id", $this->tipo_vehiculo_id);
            $stmt->bindParam(":anio", $this->anio);
            $stmt->bindParam(":color", $this->color);
            $stmt->bindParam(":placa", $this->placa);
            $stmt->bindParam(":numero_motor", $this->numero_motor);
            $stmt->bindParam(":numero_chasis", $this->numero_chasis);

            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Error en crear: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerMarcas() {
        $query = "SELECT id, nombre FROM marcas WHERE estado = true ORDER BY nombre";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error en obtenerMarcas: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerModelosPorMarca($marca_id) {
        $query = "SELECT id, nombre FROM modelos WHERE marca_id = :marca_id AND estado = true ORDER BY nombre";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":marca_id", $marca_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error en obtenerModelosPorMarca: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerTiposVehiculo() {
        $query = "SELECT id, nombre FROM tipos_vehiculo WHERE estado = true ORDER BY nombre";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error en obtenerTiposVehiculo: " . $e->getMessage());
            return [];
        }
    }

    public function verificarPlacaExistente($placa) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE placa = :placa";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":placa", $placa);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
        } catch(PDOException $e) {
            error_log("Error en verificarPlacaExistente: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerTodos() {
        $query = "SELECT a.*, 
                         m.nombre as marca, 
                         mo.nombre as modelo,
                         tv.nombre as tipo_vehiculo
                  FROM " . $this->table_name . " a
                  LEFT JOIN marcas m ON a.marca_id = m.id
                  LEFT JOIN modelos mo ON a.modelo_id = mo.id
                  LEFT JOIN tipos_vehiculo tv ON a.tipo_vehiculo_id = tv.id
                  ORDER BY a.placa";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error en obtenerTodos: " . $e->getMessage());
            return false;
        }
    }
    
 
    public function eliminar($placa) {
        try {
            // Primero verificamos si existen registros relacionados
            $query = "DELETE FROM " . $this->table_name . " WHERE placa = :placa";
            $stmt = $this->conn->prepare($query);
            
            // Limpiamos y vinculamos el parámetro
            $placa = htmlspecialchars(strip_tags($placa));
            $stmt->bindParam(":placa", $placa);
            
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Error en eliminar: " . $e->getMessage());
            return false;
        }
    }
    
        // Método para buscar automóvil por placa
        public function buscarPorPlaca($placa = null) {
            if ($placa) {
                // Si se proporciona una placa específica
                $query = "SELECT * FROM " . $this->table_name . " WHERE placa LIKE :placa";
                $stmt = $this->conn->prepare($query);
                $placaParam = "%{$placa}%"; // Esto permite búsqueda parcial
                $stmt->bindParam(':placa', $placaParam);
            } else {
                // Si no se proporciona placa, retorna todos los registros
                $query = "SELECT * FROM " . $this->table_name . " ORDER BY placa ASC";
                $stmt = $this->conn->prepare($query);
            }
            
            try {
                $stmt->execute();
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Si no hay resultados con la placa específica, retorna todos los registros
                if (empty($resultados) && $placa) {
                    $query = "SELECT * FROM " . $this->table_name . " ORDER BY placa ASC";
                    $stmt = $this->conn->prepare($query);
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                
                return $resultados;
            } catch (PDOException $e) {
                // Manejo de errores
                error_log("Error en buscarPorPlaca: " . $e->getMessage());
                return false;
            }
        }
        public function actualizar() {
            try {
                $query = "UPDATE " . $this->table_name . " 
                          SET marca_id = :marca_id, 
                              modelo_id = :modelo_id, 
                              tipo_vehiculo_id = :tipo_vehiculo_id,
                              anio = :anio, 
                              color = :color, 
                              numero_motor = :numero_motor, 
                              numero_chasis = :numero_chasis 
                          WHERE placa = :placa";
                          
                $stmt = $this->conn->prepare($query);
        
                // Asociar parámetros usando los nuevos campos _id
                $stmt->bindParam(':marca_id', $this->marca_id, PDO::PARAM_INT);
                $stmt->bindParam(':modelo_id', $this->modelo_id, PDO::PARAM_INT);
                $stmt->bindParam(':tipo_vehiculo_id', $this->tipo_vehiculo_id, PDO::PARAM_INT);
                $stmt->bindParam(':anio', $this->anio, PDO::PARAM_INT);
                $stmt->bindParam(':color', $this->color);
                $stmt->bindParam(':placa', $this->placa);
                $stmt->bindParam(':numero_motor', $this->numero_motor);
                $stmt->bindParam(':numero_chasis', $this->numero_chasis);
        
                // Ejecutar consulta
                if($stmt->execute()) {
                    return true;
                }
        
                return false;
            } catch(PDOException $e) {
                error_log("Error en actualizar: " . $e->getMessage());
                return false;
            }
        }
        
        
    }
    ?>
