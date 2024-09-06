<?php
class Automovil {
    private $conn; // Conexión a la base de datos
    private $table_name = "automovil"; // Nombre de la tabla

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


    // Método para obtener todos los automóviles registrados
    public function obtenerAutomoviles() {
        // Query para obtener todos los automóviles
        $query = "SELECT * FROM " . $this->table_name;

        // Preparar la declaración
        $stmt = $this->conn->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        return $stmt;
    }
    
    
    public function buscarAutomoviles($searchTerm) {
        if ($searchTerm) {
            // Si hay un término de búsqueda, filtrar por placa o modelo
            $query = "SELECT * FROM " . $this->table_name . " WHERE placa LIKE :searchTerm OR modelo LIKE :searchTerm";
            $stmt = $this->conn->prepare($query);
            $searchTerm = "%{$searchTerm}%"; // Añadir comodines para la búsqueda con LIKE
            $stmt->bindParam(':searchTerm', $searchTerm);
        } else {
            // Si no hay término de búsqueda, obtener todos los registros
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
        }
    
        // Ejecutar la consulta
        $stmt->execute();
    
        return $stmt;
    }
    
    public function obtenerAutomovilPorId($placa) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE placa = :placa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':placa', $placa);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarAutomovil() {
        $query = "UPDATE " . $this->table_name . " 
                  SET placa = :placa, marca = :marca, modelo = :modelo, anio = :anio, color = :color 
                  WHERE placa = :placa";
    
        $stmt = $this->conn->prepare($query);
    
        // Limpiar los datos
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->anio = htmlspecialchars(strip_tags($this->anio));
        $this->color = htmlspecialchars(strip_tags($this->color));
    
    
        // Enlazar los parámetros
        $stmt->bindParam(':placa', $this->placa);
        $stmt->bindParam(':marca', $this->marca);
        $stmt->bindParam(':modelo', $this->modelo);
        $stmt->bindParam(':anio', $this->anio);
        $stmt->bindParam(':color', $this->color);
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        } else {
            // Si falla, puedes imprimir el error para depurar
            print_r($stmt->errorInfo());
            return false;
        }
    }
    
    public function eliminarAutomovil() {
        // Consulta SQL para eliminar el automóvil por su ID
        $query = "DELETE FROM " . $this->table_name . " WHERE placa = :placa";
        
        // Preparar la declaración
        $stmt = $this->conn->prepare($query);
        
        // Limpiar el ID
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        
        // Enlazar el ID
        $stmt->bindParam(':placa', $this->placa);
        
        // Ejecutar la declaración
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    
}
?>
