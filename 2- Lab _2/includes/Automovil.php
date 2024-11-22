<?php
class Automovil {
    private $conn; // Conexión a la base de datos
    private $table_name = "automoviles"; // Nombre de la tabla

    // Propiedades de la clase
    public $id;
    public $marca;
    public $modelo;
    public $anio;
    public $color;
    public $placa;
    public $numero_motor;
public $numero_chasis;
public $tipo_vehiculo;


    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo automóvil
    public function registrar() {
        // Query para insertar un nuevo automóvil
        $query = "INSERT INTO automoviles (marca, modelo, anio, color, placa, numero_motor, numero_chasis, tipo_vehiculo)
              VALUES (:marca, :modelo, :anio, :color, :placa, :numero_motor, :numero_chasis, :tipo_vehiculo)";

        // Preparar la declaración
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos para evitar inyección SQL
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->anio = htmlspecialchars(strip_tags($this->anio));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->numero_motor = htmlspecialchars(strip_tags($this->numero_motor));
        $this->numero_chasis = htmlspecialchars(strip_tags($this->numero_chasis));
        $this->tipo_vehiculo = htmlspecialchars(strip_tags($this->tipo_vehiculo));

        // Enlazar los parámetros
        $stmt->bindParam(":marca", $this->marca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":anio", $this->anio);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":placa", $this->placa);
        $stmt->bindParam(':numero_motor', $this->numero_motor);
        $stmt->bindParam(':numero_chasis', $this->numero_chasis);
        $stmt->bindParam(':tipo_vehiculo', $this->tipo_vehiculo);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }



        // Método para obtener todos los automóviles
        public function obtenerTodos() {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            $query = "UPDATE " . $this->table_name . " 
                      SET marca = :marca, 
                          modelo = :modelo, 
                          anio = :anio, 
                          color = :color, 
                          numero_motor = :numero_motor, 
                          numero_chasis = :numero_chasis, 
                          tipo_vehiculo = :tipo_vehiculo 
                      WHERE placa = :placa";
                      
            $stmt = $this->conn->prepare($query);
        
            // Asociar parámetros
            $stmt->bindParam(':marca', $this->marca);
            $stmt->bindParam(':modelo', $this->modelo);
            $stmt->bindParam(':anio', $this->anio);
            $stmt->bindParam(':color', $this->color);
            $stmt->bindParam(':placa', $this->placa);
            $stmt->bindParam(':numero_motor', $this->numero_motor);
            $stmt->bindParam(':numero_chasis', $this->numero_chasis);
            $stmt->bindParam(':tipo_vehiculo', $this->tipo_vehiculo);
        
            // Ejecutar consulta
            return $stmt->execute();
        }
        
        
    }
    ?>
