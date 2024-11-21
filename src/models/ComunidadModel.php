<?php
namespace admin\foro\Models;

class ComunidadModel extends Model {

    public function __construct()
    {
        parent::__construct();
        $this->tabla="comunidades";
    }
    public function getComunidades(){
        $sql="SELECT *  from  {$this->tabla}";
        $consulta=$this->conn->prepare($sql);
        $consulta->execute();
        $resultado=$consulta->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function getComunidadesHome(){
        $sql="SELECT *  from  {$this->tabla}";
        $consulta=$this->conn->prepare($sql);
        $consulta->execute();
        $resultado=$consulta->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function getComunidadesUnido($idUsuario){
        $sql="SELECT c.* 
        FROM comunidades c 
        JOIN membresias m ON c.id_comunidad = m.id_comunidad
         WHERE m.id_usuario = :idUsuario;"; 
        $consulta=$this->conn->prepare($sql);
        $consulta->bindParam(":idUsuario", $idUsuario);
        $consulta->execute();
        $resultado=$consulta->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }
}
