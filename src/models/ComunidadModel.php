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
        $sql = "SELECT c.nombre,c.imagen, COUNT(m.id_usuario) AS numero_de_usuarios
                FROM comunidades c
                LEFT JOIN membresias m ON c.id_comunidad = m.id_comunidad
            GROUP BY c.id_comunidad
            ORDER BY numero_de_usuarios DESC;";
        $consulta = $this->conn->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function getComunidadesHome()
    {
        $sql = "SELECT *  from  {$this->tabla}";
        $consulta = $this->conn->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function getComunidadesUnido($idUsuario)
    {
        $sql = "SELECT c.* 
        FROM comunidades c 
        JOIN membresias m ON c.id_comunidad = m.id_comunidad
         WHERE m.id_usuario = :idUsuario;";
        $consulta = $this->conn->prepare($sql);
        $consulta->bindParam(":idUsuario", $idUsuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function comunidadesPorNombre($idComunidad)
    {
        $sql = "SELECT c.* 
        FROM comunidades c 
         WHERE id_comunidad = :idComunidad;";
        $consulta = $this->conn->prepare($sql);
        $consulta->bindParam(":idComunidad", $idComunidad);
        $consulta->execute();
        $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }
}
