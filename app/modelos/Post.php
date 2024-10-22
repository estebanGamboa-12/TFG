<?php

require '../../config/conectar.php';
class Post
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conectar::conexion(); // Conecta a la base de datos
    }

    public function obtenerPostAleatorios()
    {
        $sql = "SELECT * FROM post "; // Limitar resultados si es necesario
        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC); // Devuelve los resultados
    }
}
?>