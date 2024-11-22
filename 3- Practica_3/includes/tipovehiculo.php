<?php
class tipovehiculo {
    private $conn;
    private $table_name = "tipos_vehiculo";

    // Propiedades
    public $id;
    public $nombre;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listar() {
        try {
            $query = "SELECT id, nombre FROM " . $this->table_name . " 
                     ORDER BY nombre";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Marca::listar: " . $e->getMessage());
            return [];
        }
    }
}