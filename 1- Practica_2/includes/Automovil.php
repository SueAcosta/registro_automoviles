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

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo automóvil
    public function registrar() {
        // Query para insertar un nuevo automóvil
        $query = "INSERT INTO " . $this->table_name . " (marca, modelo, anio, color, placa) VALUES (:marca, :modelo, :anio, :color, :placa)";

        // Preparar la declaración
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos para evitar inyección SQL
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->anio = htmlspecialchars(strip_tags($this->anio));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->placa = htmlspecialchars(strip_tags($this->placa));

        // Enlazar los parámetros
        $stmt->bindParam(":marca", $this->marca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":anio", $this->anio);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":placa", $this->placa);

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
        public function buscarPorPlaca($placa) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE placa = :placa";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':placa', $placa);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function eliminar($placa) {
            $query = "DELETE FROM " . $this->table_name . " WHERE placa = :placa";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':placa', $placa);
            return $stmt->execute();
        }
        
        public function actualizar() {
            $query = "UPDATE " . $this->table_name . " 
                      SET marca = :marca, modelo = :modelo, anio = :anio, color = :color
                      WHERE placa = :placa";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':marca', $this->marca);
            $stmt->bindParam(':modelo', $this->modelo);
            $stmt->bindParam(':anio', $this->anio);
            $stmt->bindParam(':color', $this->color);
            $stmt->bindParam(':placa', $this->placa);
            return $stmt->execute();
        }
        
    }
    ?>
