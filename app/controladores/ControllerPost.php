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
        header('Content-Type: application/json'); // Establece el tipo de contenido para JSON
        $m = new Post();
        $posts = $m->obtenerPostAleatorios();
        
        echo json_encode($posts);
        
        include 'app/vistas/main.php';
    }

    
}
$controller=new ControllerPost();
$controller->mostrarPostAleatorios();
