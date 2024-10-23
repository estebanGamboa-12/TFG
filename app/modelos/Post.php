<?php

class Post
{
    private $conexion;
    private $posts;

    public function __construct()
    {
        $this->conexion = Conectar::conexion(); // Conecta a la base de datos
        $this->posts=array();
    }

    public function obtenerPostAleatorios()
    {
        $sql = "SELECT p.titulo, p.contenido,p.fecha_creacion,u.nombre,u.imagen FROM post p JOIN usuarios u ON p.id=u.id; "; 
        try{
            $consulta=$this->conexion->prepare($sql);
            $consulta->execute();
            
            while($dato=$consulta->fetch(PDO::FETCH_ASSOC)){
                $this->posts[]=$dato;
            }
            return $this->posts;

        }catch(PDOException $e){
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" .  $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
}
?>