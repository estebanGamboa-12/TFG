<?php

class ControllerPost
{
    private $conexion;
    private $mostrar;

    public function __construct()
    {
        $this->conexion = Conectar::conexion(); // Asegúrate de que la clase Post esté definida correctamente
        
    }

    public function mostrarForm()// 
    {
    require "app/vistas/crearPost.php";
    exit;

    }
    public function subirPost() {
        
        $postModel=new Post();
        $post=$postModel->subirPost();
        $postModel->cerrar_conexion();
       
        header('location:index.php');
        exit;
        

    }
    public function mostrarPostPopulares()// inicio y la parte populares logeado es la misma
    {
        $post=new Post();
        $datos=$post->getPostPopular();
        $post->cerrar_conexion();
        include 'app/vistas/main.php';
    }

}
