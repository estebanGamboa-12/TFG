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
}
