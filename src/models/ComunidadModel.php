<?php

namespace admin\foro\Models;

class ComunidadModel extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->tabla = "comunidades";
    }
    public function getComunidadesPopulares()
    {
        try {
            $sql = "SELECT c.nombre,c.imagen, COUNT(m.id_usuario) AS numero_de_usuarios
                FROM comunidades c
                LEFT JOIN membresias m ON c.id_comunidad = m.id_comunidad
            GROUP BY c.id_comunidad
            ORDER BY numero_de_usuarios DESC;";
            $consulta = $this->conn->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function getComunidadesHome()
    {
        try {
            $sql = "SELECT *  from  {$this->tabla}";
            $consulta = $this->conn->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function getComunidadesUnido($idUsuario)
    {
        try {
            $sql = "SELECT c.* 
        FROM comunidades c 
        JOIN membresias m ON c.id_comunidad = m.id_comunidad
         WHERE m.id_usuario = :idUsuario;";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idUsuario", $idUsuario);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function comunidadesPorNombre($nombre)
    {
        try {
            $sql = "SELECT c.* 
        FROM comunidades c 
         WHERE c.nombre = :nombre;";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":nombre", $nombre);
            $consulta->execute();
            $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function datosComunidad($nombre,$idUsuario)
    {
        try {
            $sql = "SELECT 
            c.*,
            COUNT(m.id_membresia) AS numero_usuarios,
            SUM(CASE WHEN m.id_usuario = :id_usuario THEN 1 ELSE 0 END) AS usuario_unido
        FROM comunidades c
        LEFT JOIN membresias m ON m.id_comunidad = c.id_comunidad
        WHERE c.nombre = :nombre
        GROUP BY c.id_comunidad;";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":nombre", $nombre);
            $consulta->bindParam(":id_usuario", $idUsuario);
            $consulta->execute();
            $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function insertarComunidad($idUsuario, $nombre, $descripcion, $imagen)
    {
        $sql = "INSERT INTO comunidades
        ( nombre, descripcion,fecha_creacion, imagen, id_usuario) 
        VALUES (:nombre,:descripcion,current_timestamp(),:imagen,:idUsuario);
        ";
        $consulta = $this->conn->prepare($sql);
        $consulta->bindParam(":nombre", $nombre);
        $consulta->bindParam(":descripcion", $descripcion);
        $consulta->bindParam(":imagen", $imagen);
        $consulta->bindParam(":idUsuario", $idUsuario);
        return $consulta->execute();
    }
    public function getComunidades()
    {
        try {
            $sql = "SELECT 
    c.*,
    COUNT(m.id_membresia) AS numero_usuarios
FROM comunidades c
LEFT JOIN membresias m ON m.id_comunidad = c.id_comunidad
GROUP BY c.id_comunidad";
            $consulta = $this->conn->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
}
