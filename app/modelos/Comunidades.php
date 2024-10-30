<?php

class Comunidades {

    private $conexion;
    private $comunidades;

    public function __construct()
    {
        $this->conexion=Conectar::conexion();
        $this->comunidades=array();
    }
    public function getAll(){
        $sql="SELECT * FROM comunidades";
        $consulta=$this->conexion->prepare($sql);
        $consulta->execute();
        while ($dato = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $this->comunidades[] = $dato;
        }
        return $this->comunidades;

    }


    public function cerrar_conexion()
    {
        $this->conexion = NULL;
    }
}
