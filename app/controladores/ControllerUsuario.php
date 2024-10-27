<?php 

class ControllerUsuario{
    private $conexion;

    public function __construct()
    {
        $this->conexion= Conectar::conexion();
        
    }
    public function iniciarSesion(){
        $m=new Usuario();
        $datos=$m->iniciarSesion();
        $m->cerrar_conexion();
        
        require_once "app/vistas/logeado.php";
    }
    public function registrarUsuarios(){
        $m=new Usuario();
        $datos=$m->registrarUsuario();
        $m->cerrar_conexion();
    }
    
}



?>