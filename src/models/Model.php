<?php

namespace admin\foro\Models;


namespace admin\foro\Models;

use admin\foro\Database\Conexion;

class Model
{
    protected $conn;
    protected $tabla;

    public function __construct()
    {
        $this->conn = Conexion::conectar();
    }

    public function getOne($id)
    {
        try {

            $consulta = "select * from {$this->tabla} where idColaborador = :id";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':id', $id);
            //$sentencia->setFetchMode(\PDO::FETCH_ASSOC);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();

            $resultado = $sentencia->fetch();
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function getAll()
    {
        try {
            $sql = "SELECT * FROM {$this->tabla}";
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
    public function cerrar_conexion()
    {
        $this->conn = NULL;
    }
}
