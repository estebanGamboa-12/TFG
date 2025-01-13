<?php

namespace admin\foro\Models;

class MembresiaModel extends Model
{


    public function __construct()
    {
        parent::__construct();
        $this->tabla = "membresias";
    }
    public function getNumeroMiembros($idComunidad)
    {
        try {
            $sql = "SELECT * 
        FROM membresias m 
        JOIN comunidades c ON m.id_comunidad = c.id_comunidad 
        WHERE m.id_comunidad = :idComunidad";

            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idComunidad", $idComunidad);
            $consulta->execute();
            return $consulta->rowCount();
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function comprobarSiEstaUnido($idUsuario, $idComunidad)
    {
        try {
            $sql = "SELECT * 
        FROM membresias m 
        WHERE id_comunidad = :idComunidad AND
            id_usuario = :idUsario";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idComunidad", $idComunidad);
            $consulta->bindParam(":idUsario", $idUsuario);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function unirseComunidad($idUsuario, $idComunidad)
    {
        try {
            $sql = "INSERT INTO membresias
         ( id_usuario, id_comunidad, fecha_unido) 
         VALUES (:idUsuario,:idComunidad , current_timestamp());";

            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idUsuario", $idUsuario);
            $consulta->bindParam(":idComunidad", $idComunidad);
            $consulta->execute();
            return $consulta->rowCount();
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
        public function dejarDeSeguirComunidad($idUsuario, $idComunidad)
        {
            try {
                $sql = "DELETE FROM membresias
                        WHERE id_usuario = :idUsuario AND id_comunidad = :idComunidad";
        
                $consulta = $this->conn->prepare($sql);
                $consulta->bindParam(":idUsuario", $idUsuario);
                $consulta->bindParam(":idComunidad", $idComunidad);
                return $consulta->execute();
                
            } catch (\PDOException $e) {
                echo "<h1><br>Fichero: " . $e->getFile();
                echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
                die($e->getMessage());
            }
        }
}
