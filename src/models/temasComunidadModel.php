<?php

namespace admin\foro\Models;

class temasComunidadModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->tabla = "temas-comunidades";
    }

    public function insertarTemasEnComunidad($idTema, $idComunidad)
    {
        try {
            $sql = "INSERT INTO `temas-comunidades` (id_tema, id_comunidad) 
                    VALUES (:idTema, :idComunidad);";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idTema", $idTema);
            $consulta->bindParam(":idComunidad", $idComunidad);
            return $consulta->execute();
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea: " . $e->getLine() . "<br>Mensaje: ";
            die($e->getMessage());
        }
    }

    public function obtenerUltimaComunidad()
    {
        try {
            $sql = "SELECT * FROM comunidades ORDER BY fecha_creacion DESC LIMIT 1";
            $consulta = $this->conn->prepare($sql);
            $consulta->execute();
            return $consulta->fetch(\PDO::FETCH_ASSOC); // Devuelve la última comunidad como un array asociativo
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea: " . $e->getLine() . "<br>Mensaje: ";
            die($e->getMessage());
        }
    }
    public function getTemasPorComunidad($idComunidad)
    {
        try {
            $sql = "SELECT * FROM  `temas-comunidades` WHERE id_comunidad = :idComunidad";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idComunidad",$idComunidad);
            $consulta->execute();
            return $consulta->fetchAll(\PDO::FETCH_ASSOC); // Devuelve la última comunidad como un array asociativo
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea: " . $e->getLine() . "<br>Mensaje: ";
            die($e->getMessage());
        }
    }
    public function getComunidadesPorTema($idtema)
    {
        try {
            $sql = "SELECT * FROM  `temas-comunidades` WHERE id_tema = :idTema";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idTema",$idtema);
            $consulta->execute();
            return $consulta->fetchAll(\PDO::FETCH_ASSOC); // Devuelve la última comunidad como un array asociativo
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea: " . $e->getLine() . "<br>Mensaje: ";
            die($e->getMessage());
        }
    }
}
