<?php

namespace admin\foro\Controllers;

use admin\foro\Models\PostModel;

class PostController
{

    public function index() // inicio y la parte populares logeado es la misma
    {
        $postModel = new PostModel();

        $post = $postModel->getPostPopular();
        
       ViewController::show("views/post/main.php", ['post'=>$post]);
    }
    public function mostrarForm() // 
    {
        require "app/vistas/crearPost.php";
        exit;
    }
    public function subirPost()
    {

        $postModel = new PostModel();
        $post = $postModel->subirPost();
        $postModel->cerrar_conexion();

        header('location:index.php');
        exit;
    }
}
