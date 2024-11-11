<?php

namespace admin\foro\Models;

class MembresiaModel extends Model
{


    public function __construct()
    {
        parent::__construct();
        $this->tabla = "membresias";
    }
    public function getMembresias($idComunidad)
    {
        $sql = "SELECT * 
        FROM membresias m 
        JOIN comunidades c ON m.id_comunidad = c.id 
        WHERE m.id_comunidad = :idComunidad";

        $consulta = $this->conn->prepare($sql);
        $consulta->bindParam(":idComunidad", $idComunidad);
        $consulta->execute();

        return $consulta->rowCount();
    }
}
