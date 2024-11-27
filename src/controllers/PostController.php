<?php

namespace admin\foro\Controllers;

use admin\foro\Config\Parameters;
use  admin\foro\Helpers\Authentication;
use admin\foro\Models\PostModel;
use \Firebase\JWT\JWT;

class PostController
{

    public function popular() // populares 
    {
        if (Authentication::isUserLogged()) {
            $postModel = new PostModel();

            $idUsuario = $_SESSION['user']['idUsuario'];
            $post = $postModel->getPostPopular($idUsuario);

            ViewController::show("views/post/popular.php", ['post' => $post]);
        } else {
            ViewController::showError(403);
        }
    }
    public function mostrarForm() //vista formulario para subir post 
    {
        if (Authentication::isUserLogged()) {
            ViewController::show("views/post/crearPost.php");
            exit;
        } else {
            ViewController::showError(403);
        }
    }
    public function subirPost() //subir un post desde el formulario crearPost.php
    {
        if (Authentication::isUserLogged()) {
            //tengo que acabar estooo.
            $postModel = new PostModel();
            var_dump($_POST); //aqui debeoms 
            exit;
            $post = $postModel->subirPost();
            header('Location:' . Parameters::$BASE_URL . "Post/home");
            exit;
        } else {
            ViewController::showError(403);
        }
    }
    public function home() // home 
    {
        if (Authentication::isUserLogged()) {
            $postModel = new PostModel();

            $idUsuario = $_SESSION['user']['idUsuario'];
            $post = $postModel->getPostHome($idUsuario);

            ViewController::show("views/post/home.php", ['post' => $post]);
        } else {
            ViewController::showError(403);
        }
    }
    public function All() // All 
    {
        if (Authentication::isUserLogged()) {
            $postModel = new PostModel();
            $idUsuario = $_SESSION['user']['idUsuario'];
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $postPorPagina = 15;
            $token = [];
            $posts = $postModel->getAllPost($idUsuario, $pagina, $postPorPagina);
            foreach ($posts as $post) {
                if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                    $token[$post['id_post']] = self::generarToken($post['id_usuario'], $post['id_comunidad'], $post['id_post']);
                    $post['token'] = self::generarToken($post['id_usuario'], $post['id_comunidad'], $post['id_post']);
                } else {
                    $post['jwt_token'] = null;
                }
            }
            ViewController::show("views/post/all.php", [
                'post' => $post, 
                "token" => $token]);
        } else {
            ViewController::showError(403);
        }
    }
    public static function generarToken($idUsuario, $idComunidad, $idpost)
    {
        $token_data = array(
            "id_usuario" => $idUsuario,
            "id_comunidad" => $idComunidad,
            "id_post" => $idpost,
        );
        $key = "123"; //clave secreta
        $alg = 'HS256';
        $jwt = JWT::encode($token_data, $key, $alg);
        return $jwt;
        // Generar el token JWT
    }
    public function popularNoLogeado() // popular cuando no esta logeado 
    {
        $postModel = new PostModel();
        $post = $postModel->getPostPopularNoLogeado();
        ViewController::show("views/post/popularNoLogeado.php", ['post' => $post]);
    }
    public function loadMorePosts()
    {
        header('Content-Type: application/json');
        if (Authentication::isUserLogged()) {

            $postModel = new PostModel();

            $idUsuario = $_SESSION['user']['idUsuario'];

            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['pagina'])) {
                echo json_encode(['success' => false, 'message' => 'Falta el parámetro de la página']);
                exit;
            }

            $pagina = $data['pagina'];

            $postsPorPagina = 15;

            $posts = $postModel->getAllPost($idUsuario, $pagina, $postsPorPagina);

            if ($posts) {
                echo json_encode([
                    'success' => true,
                    'posts' => $posts
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se encontraron más posts'
                ]);
            }
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
            exit;
        }
    }
}
