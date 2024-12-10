<?php

namespace admin\foro\Controllers;

use admin\foro\Config\Parameters;
use  admin\foro\Helpers\Authentication;
use admin\foro\Models\ComentariosModel;
use admin\foro\Models\PostModel;
use Exception;
use \Firebase\JWT\JWT;
use Firebase\JWT\JWTExceptionWithPayloadInterface;
use Firebase\JWT\Key;

class PostController
{
    public function verPostPorId()
    {
        if (isset($_GET['titulo'])) {
            $postModel = new PostModel();
            $comentariosModel=new ComentariosModel();
            $idPost = $_GET['titulo'];
            $posts = $postModel->postPorId($idPost);
            $comentarios=$comentariosModel->comentariosDeUnPost($idPost);
            ViewController::show("views/comentarios/vistaComentarios.php",[
                "post"=>$posts,
                "comentarios"=>$comentarios,
            ]);
        } else {

            header('Content-Type: application/json');

            $rowdata = file_get_contents('php://input');
            $data = json_decode($rowdata, true);

            // Verifica que el token se haya enviado
            if (!isset($data['token'])) {
                http_response_code(400); // Bad Request
                echo json_encode(["success" => false, "mensaje" => "Token no proporcionado"]);
                return;
            }

            $token = $data['token'];
            $key = $_SESSION['key'];
            $alg = $_SESSION['alg'];

            try {
                // Intentamos decodificar el JWT
                $decoded = JWT::decode($token, new Key($key, $alg));

                $idUsuario = $decoded->id_usuario;
                $idComunidad = $decoded->id_comunidad;
                $idPost = $decoded->id_post;

                $postModel = new PostModel();
                $posts = $postModel->postPorId($idPost);

                // Verifica si el post existe
                if (!$posts) {
                    http_response_code(404); // Not Found
                    echo json_encode(["success" => false, "mensaje" => "Post no encontrado"]);
                    return;
                }

                // Devuelve la respuesta exitosa con el post
                echo json_encode(["success" => true, "post" => $posts]);
            } catch (JWTExceptionWithPayloadInterface $e) {
                http_response_code(401); // Unauthorized
                echo json_encode(["success" => false, "mensaje" => "Token inválido o expirado"]);
            } catch (\PDOException $e) {
                http_response_code(500); // Internal Server Error
                echo json_encode(["success" => false, "mensaje" => "Hubo un error con la base de datos"]);
            } catch (Exception $e) {
                http_response_code(500); // Internal Server Error
                echo json_encode(["success" => false, "mensaje" => "Hubo un error inesperado. Intente más tarde"]);
            }
        }
    }



    public function popular() // populares 
    {
        if (Authentication::isUserLogged()) {
            $postModel = new PostModel();
            $_SESSION['cambioVista'] = "";
            $idUsuario = $_SESSION['user']['idUsuario'];
            $pagina = 1;
            $postPorPagina = 15;
            $token = [];
            $posts = $postModel->getPostPopular($idUsuario, $pagina, $postPorPagina);
            foreach ($posts as $post) {
                if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                    $token[$post['id_post']] = self::generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                } else {
                    $post['jwt_token'] = null;
                }
            }

            ViewController::show("views/post/popular.php", ['post' => $posts, "token" => $token]);
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
            $_SESSION['cambioVista'] = "";
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
            $_SESSION['cambioVista'] = "";

            $idUsuario = $_SESSION['user']['idUsuario'];
            $pagina = 1;
            $postPorPagina = 15;
            $token = [];
            $posts = $postModel->getPostHome($idUsuario, $pagina, $postPorPagina);
            foreach ($posts as $post) {
                if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                    $token[$post['id_post']] = self::generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                } else {
                    $post['jwt_token'] = null;
                }
            }


            ViewController::show("views/post/home.php", ['post' => $posts, "token" => $token]);
        } else {
            ViewController::showError(403);
        }
    }
    public function All() // All 
    {
        if (Authentication::isUserLogged()) {
            $_SESSION['cambioVista'] = "";
            $postModel = new PostModel();
            $idUsuario = $_SESSION['user']['idUsuario'];
            $pagina = 1;
            $postPorPagina = 15;
            $token = [];
            $posts = $postModel->getAllPost($idUsuario, $pagina, $postPorPagina);
            foreach ($posts as $post) {
                if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                    $token[$post['id_post']] = self::generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                } else {
                    $post['jwt_token'] = null;
                }
            }
            ViewController::show("views/post/all.php", [
                'post' => $posts,
                "token" => $token
            ]);
        } else {
            ViewController::showError(403);
        }
    }

    public function popularNoLogeado() // popular cuando no esta logeado 
    {
        $_SESSION['cambioVista'] = "todasComunidades";
        $postModel = new PostModel();
        $pagina = 1;
        $postPorPagina = 15;
        $post = $postModel->getPostPopularNoLogeado($pagina, $postPorPagina);
        ViewController::show("views/post/popularNoLogeado.php", ['post' => $post]);
    }
    public function loadMorePosts() //cargar mas post de las vistas (all,home,popular);
    {
        header('Content-Type: application/json');
        if (Authentication::isUserLogged()) {
            $_SESSION['cambioVista'] = "";

            $postModel = new PostModel();

            $data = json_decode(file_get_contents('php://input'), true);
            //variables
            $idUsuario = $_SESSION['user']['idUsuario'];
            $pagina = $data['pagina'];
            $postsPorPagina = 10;
            $token = [];
            $vista = $data['vista'];

            if (!isset($data['pagina'])) {
                echo json_encode(['success' => false, 'message' => 'Falta el parámetro de la página']);
                exit;
            }
            if (!isset($data['vista'])) {
                echo json_encode(['success' => false, 'message' => 'Ocurrio un erro (132 post controller)']);
                exit;
            }
            /*var_dump($vista);
            exit;*/
            switch ($vista) {
                case 'all':
                    $posts = $postModel->getAllPost($idUsuario, $pagina, $postsPorPagina);
                    foreach ($posts as $post) {
                        $idUsuario = $_SESSION['user']['idUsuario'];
                        if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                            $token[$post['id_post']] = self::generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                        } else {
                            $post['jwt_token'] = null;
                        }
                    }
                    break;
                case 'home':
                    $posts = $postModel->getPostHome($idUsuario, $pagina, $postsPorPagina);
                    foreach ($posts as $post) {
                        $idUsuario = $_SESSION['user']['idUsuario'];
                        if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                            $token[$post['id_post']] = self::generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                        } else {
                            $post['jwt_token'] = null;
                        }
                    }
                    break;
                case 'popular':
                    $posts = $postModel->getPostPopular($idUsuario, $pagina, $postsPorPagina);
                    foreach ($posts as $post) {
                        $idUsuario = $_SESSION['user']['idUsuario'];
                        if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                            $token[$post['id_post']] = self::generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                        } else {
                            $post['jwt_token'] = null;
                        }
                    }
                    break;

                default:
                    echo json_encode(['success' => false, 'message' => 'Ocurrio un error inesperado (145 postContr)']);
                    exit;
                    break;
            }
            if ($posts) {
                echo json_encode([
                    'success' => true,
                    'posts' => $posts,
                    'token' => $token,
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
    public static function generarToken($idUsuario, $idComunidad, $idpost)
    {
        $token_data = array(
            "id_usuario" => $idUsuario,
            "id_comunidad" => $idComunidad,
            "id_post" => $idpost,
        );
        $key = "123"; //clave secreta
        $alg = 'HS256';
        $_SESSION['key'] = $key;
        $_SESSION['alg'] = $alg;
        $jwt = JWT::encode($token_data, $key, $alg);
        return $jwt;
        // Generar el token JWT
    }
}
