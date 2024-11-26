<?php

namespace admin\foro\Controllers;

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;
use admin\foro\Models\PostModel;

class PostController
{

    public function popular() // populares 
    {
        if (Authentication::isUserLogged()) {
        $postModel = new PostModel();

        $idUsuario=$_SESSION['user']['idUsuario'];
        $post = $postModel->getPostPopular($idUsuario);
        
       ViewController::show("views/post/verPost.php", ['post'=>$post]);
    } else {
        ViewController::showError(403);
    }
    }
    public function mostrarForm() //vista formulario para subir post 
    {
        if (Authentication::isUserLogged()) {
        ViewController::show( "views/post/crearPost.php");
        exit;
    } else {
        ViewController::showError(403);
    }
    }
    public function subirPost()//subir un post desde el formulario crearPost.php
    {
        if (Authentication::isUserLogged()) {
        //tengo que acabar estooo.
        $postModel = new PostModel();
        var_dump($_POST);//aqui debeoms 
        exit;
        $post = $postModel->subirPost();
        header('Location:' . Parameters::$BASE_URL ."Post/home");
        exit;
    } else {
        ViewController::showError(403);
    }
    }
    public function home() // home 
    {
        if (Authentication::isUserLogged()) {
        $postModel = new PostModel();

        $idUsuario=$_SESSION['user']['idUsuario'];
        $post = $postModel->getPostHome($idUsuario);
        
       ViewController::show("views/post/home.php", ['post'=>$post]);
    } else {
        ViewController::showError(403);
    }
    }
    public function All() // All 
    {
        if (Authentication::isUserLogged()) {
        $postModel = new PostModel();
        $idUsuario=$_SESSION['user']['idUsuario'];
        $pagina=isset($_GET['pagina']) ? (int)$_GET['pagina']:1;
        $postPorPagina=15;
        $post = $postModel->getAllPost($idUsuario,$pagina,$postPorPagina);
       ViewController::show("views/post/all.php", ['post'=>$post]);
    } else {
        ViewController::showError(403);
    }
    }
    public function popularNoLogeado() // popular cuando no esta logeado 
    {
        $postModel = new PostModel();
        $post = $postModel->getPostPopularNoLogeado();
       ViewController::show("views/post/popularNoLogeado.php", ['post'=>$post]);
    }
    public function loadMorePosts() 
{
    if (Authentication::isUserLogged()) {
        $postModel = new PostModel();
        $idUsuario = $_SESSION['user']['idUsuario'];
        
        // Obtener el número de la página
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;  // Por defecto, cargamos la página 1
        $postsPorPagina = 15; // Número de posts por página

        // Obtener los posts para esa página
        $posts = $postModel->getAllPost($idUsuario, $pagina, $postsPorPagina);

        // Devolver los posts como JSON
        echo json_encode([
            'success' => true,
            'posts' => $posts
        ]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }
}


}
