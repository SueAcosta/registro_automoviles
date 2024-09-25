<?php
class Automovil {
    private $conn;
    private $table_name = "automovil";

    public $placa;
    public $marca;
    public $modelo;
    public $anio;
    public $color;
    public $n_motor;
    public $n_chasis;
    public $t_auto;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " (placa, marca, modelo, anio, color, n_motor, n_chasis, t_auto) VALUES (:placa, :marca, :modelo, :anio, :color, :n_motor, :n_chasis, :t_auto)";
        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->anio = htmlspecialchars(strip_tags($this->anio));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->n_motor = htmlspecialchars(strip_tags($this->n_motor));
        $this->n_chasis = htmlspecialchars(strip_tags($this->n_chasis));
        $this->t_auto = htmlspecialchars(strip_tags($this->t_auto));

        // Enlazar parámetros
        $stmt->bindParam(':placa', $this->placa);
        $stmt->bindParam(':marca', $this->marca);
        $stmt->bindParam(':modelo', $this->modelo);
        $stmt->bindParam(':anio', $this->anio);
        $stmt->bindParam(':color', $this->color);
        $stmt->bindParam(':n_motor', $this->n_motor);
        $stmt->bindParam(':n_chasis', $this->n_chasis);
        $stmt->bindParam(':t_auto', $this->t_auto);

        // Ejecutar
        return $stmt->execute();
    }
    public function buscarAutomoviles($searchTerm) {
        if ($searchTerm) {
            // Si hay un término de búsqueda, filtrar por placa o modelo
            $query = "SELECT a.*, t.t_auto AS tipo_nombre 
                      FROM " . $this->table_name . " a
                      JOIN tipos_a t ON a.t_auto = t.id
                      WHERE a.placa LIKE :searchTerm OR a.modelo LIKE :searchTerm";
            $stmt = $this->conn->prepare($query);
            $searchTerm = "%{$searchTerm}%"; // Añadir comodines para la búsqueda con LIKE
            $stmt->bindParam(':searchTerm', $searchTerm);
        } else {
            // Si no hay término de búsqueda, obtener todos los registros
            $query = "SELECT a.*, t.t_auto AS tipo_nombre 
                      FROM " . $this->table_name . " a
                      JOIN tipos_a t ON a.t_auto = t.id";
            $stmt = $this->conn->prepare($query);
        }
    
        // Ejecutar la consulta
        $stmt->execute();
    
        return $stmt;
    }
    

    public function obtenerAutomovilPorId($placa) {
        $query = "SELECT a.*, t.t_auto AS tipo_nombre
                  FROM " . $this->table_name . " a
                  JOIN tipos_a t ON a.t_auto = t.id
                  WHERE a.placa = :placa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':placa', $placa);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarAutomovil() {
        $query = "UPDATE " . $this->table_name . "
                  SET marca = :marca, modelo = :modelo, anio = :anio, color = :color, n_motor = :n_motor, n_chasis = :n_chasis, t_auto = :t_auto
                  WHERE placa = :placa";

        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->anio = htmlspecialchars(strip_tags($this->anio));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->n_motor = htmlspecialchars(strip_tags($this->n_motor));
        $this->n_chasis = htmlspecialchars(strip_tags($this->n_chasis));
        $this->t_auto = htmlspecialchars(strip_tags($this->t_auto));

        // Enlazar parámetros
        $stmt->bindParam(':placa', $this->placa);
        $stmt->bindParam(':marca', $this->marca);
        $stmt->bindParam(':modelo', $this->modelo);
        $stmt->bindParam(':anio', $this->anio);
        $stmt->bindParam(':color', $this->color);
        $stmt->bindParam(':n_motor', $this->n_motor);
        $stmt->bindParam(':n_chasis', $this->n_chasis);
        $stmt->bindParam(':t_auto', $this->t_auto);

        // Ejecutar
        return $stmt->execute();
    }

    public function eliminarAutomovil() {
        $query = "DELETE FROM " . $this->table_name . " WHERE placa = :placa";
        $stmt = $this->conn->prepare($query);
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $stmt->bindParam(':placa', $this->placa);
        return $stmt->execute();
    }
}
?>
