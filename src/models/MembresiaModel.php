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
        $sql = "SELECT * 
        FROM membresias m 
        JOIN comunidades c ON m.id_comunidad = c.id_comunidad 
        WHERE m.id_comunidad = :idComunidad";

        $consulta = $this->conn->prepare($sql);
        $consulta->bindParam(":idComunidad", $idComunidad);
        $consulta->execute();

        return $consulta->rowCount();
    }
    public function comprobarSiEstaUnido($idUsuario, $idComunidad)
    {
        $sql = "SELECT * 
        FROM membresias m 
        WHERE id_comunidad = :idComunidad AND
            id_usuario = :idUsario";
        $consulta = $this->conn->prepare($sql);
        $consulta->bindParam(":idComunidad",$idComunidad);
        $consulta->bindParam(":idUsario",$idUsuario);
        $consulta->execute();
        $resultado=$consulta->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function unirseComunidad($idUsuario, $idComunidad)
    {
        $sql = "INSERT INTO membresias
         ( id_usuario, id_comunidad, fecha_unido) 
         VALUES (:idUsuario,:idComunidad , current_timestamp());";

        $consulta = $this->conn->prepare($sql);
        $consulta->bindParam(":idUsuario", $idUsuario);
        $consulta->bindParam(":idComunidad", $idComunidad);
        $consulta->execute();

        return $consulta->rowCount();
    }
}
