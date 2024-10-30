<?php 

class ControllerComunidades{

    private $comunidades;
    private $conexion;
    public function __construct()
    {
        $this->conexion=Conectar::conexion();    
    }
    public function mostrarExplorar(){
        $comunidadesModal=new Comunidades();
        $comunidades=$comunidadesModal->getAll();

       // var_dump($comunidades);
            include 'app/vistas/explorarComunidades.php'
            ;      
    }
}

?>