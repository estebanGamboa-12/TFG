<?php

class ControllerPost
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conectar::conexion(); // Asegúrate de que la clase Post esté definida correctamente
    }

    public function mostrarPostAleatorios()// la parte del home
    {
        $m = new Post();
        $posts = $m->obtenerPostAleatorios();
        
        echo json_encode($posts);
        
    }
    public function mostrarPostPopulares()// inicio y la parte populares logeado es la misma
    {
        $post=new Post();
        $datos=$post->getPostPopular();
        $post->cerrar_conexion();
        //var_dump($datos);
        include 'app/vistas/main.php';
        
    }
    
}
$controller=new ControllerPost();
$controller->mostrarPostAleatorios();
