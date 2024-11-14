<?php

namespace admin\foro\Controllers;

use admin\foro\Config\Parameters;
use admin\foro\Models\PostModel;

class PostController
{

    public function popular() // populares 
    {
        $postModel = new PostModel();

        $post = $postModel->getPostPopular();
        
       ViewController::show("views/post/main.php", ['post'=>$post]);
    }
    public function mostrarForm() //vista formulario para subir post 
    {
        ViewController::show( "views/post/crearPost.php");
        exit;
    }
    public function subirPost()//subir un post desde el formulario crearPost.php
    {
        $postModel = new PostModel();
        var_dump($_POST);//aqui debeoms 
        exit;
        $post = $postModel->subirPost();
        header('Location:' . Parameters::$BASE_URL ."Post/home");
        exit;
    }
    public function home() // home 
    {
        $postModel = new PostModel();

        $idUsuario=$_SESSION['user']['idUsuario'];
        $post = $postModel->getPostHome($idUsuario);
        
       ViewController::show("views/post/home.php", ['post'=>$post]);
    }
}
