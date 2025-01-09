<?php

namespace admin\foro\Models;

class TemaModel extends Model
{


    public function __construct()
    {
        parent::__construct();
        $this->tabla = "temas";
    }
    public function getTemas()
    {
        try {
            $sql = " SELECT id_temas, nombre  FROM {$this->tabla} ";
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
    public function getTemasPorId($idTema)
    {
        try {
            $sql = " SELECT id_temas, nombre  FROM {$this->tabla} WHERE id_temas=:idTemas ";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idTemas",$idTema,\PDO::PARAM_INT);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function getTemaPorNombre($nombreTema){
        try {
            $sql = " SELECT id_temas, nombre  FROM {$this->tabla} WHERE nombre=:nombre ";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":nombre",$nombreTema,);
            $consulta->execute();
            $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }

}
