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
            $sql = " SELECT nombre  FROM {$this->tabla} ";
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
