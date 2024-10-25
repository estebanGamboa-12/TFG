<?php 

class ControllerUsuario{
    private $conexion;

    public function __construct()
    {
        $this->conexion= Conectar::conexion();
        
    }
    public function iniciarSesion(){
        $m=new Usuario();
    }
    
}



?>