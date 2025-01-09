<?php

namespace admin\foro\Controllers;

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;
use admin\foro\Helpers\GenerarToken as HelpersGenerarToken;
use admin\foro\Helpers\ImageUploader;
use admin\foro\Helpers\VideoUploader;
use admin\foro\Models\ComentariosModel;
use admin\foro\Models\ComunidadModel;
use admin\foro\Models\PostModel;
use Exception;
use \Firebase\JWT\JWT;
use Firebase\JWT\JWTExceptionWithPayloadInterface;
use Firebase\JWT\Key;
use GenerarToken;

class PostController
{

    public function verPostPorId()
    {
        if (isset($_GET['titulo'])) {
            $_SESSION['cambioVista'] = "";
            $postModel = new PostModel();
            $comentariosModel = new ComentariosModel();
            $generarToken = new HelpersGenerarToken();
            $idPost = intval($_GET['titulo']);
            $posts = $postModel->postPorId($idPost);
            $idUsuario = $_SESSION['user']['idUsuario'];
            $token = $generarToken->generarToken($idUsuario, $posts['id_comunidad'], $posts['id_post']);
            $comentarios = $comentariosModel->comentariosDeUnPost($idPost);
            // Verificar si la sesión de posts está inicializada
            if (!isset($_SESSION['post'])) {
                $_SESSION['post'] = []; // Inicializar como un array vacío
            }

            // Verificar si el array de posts para el usuario está inicializado
            if (!isset($_SESSION['post'][$idUsuario])) {
                $_SESSION['post'][$idUsuario] = []; // Inicializar como un array vacío
            }
            // Verificar si el post está vacío
            if (empty($posts)) {
                header('location:' . Parameters::$BASE_URL);
                exit;
            }
            // Verificar si el idPost ya existe en el array de posts del usuario
            if (!in_array($idPost, $_SESSION['post'][$idUsuario])) {
                // Añadir el idPost al array de posts del usuario
                $_SESSION['post'][$idUsuario][] = $idPost;
            }
            ViewController::show("views/comentarios/vistaComentarios.php", [
                "post" => $posts,
                "comentarios" => $comentarios,
                "token" => $token,
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
            $generarToken = new HelpersGenerarToken();
            $_SESSION['cambioVista'] = "verPostRecientes";
            $idUsuario = $_SESSION['user']['idUsuario'];
            $pagina = 1;
            $postPorPagina = 15;
            $token = [];
            $posts = $postModel->getPostPopular($idUsuario, $pagina, $postPorPagina);
            foreach ($posts as $post) {
                if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                    $token[$post['id_post']] = $generarToken->generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                } else {
                    $post['jwt_token'] = null;
                }
            }
            ViewController::show("views/post/popular.php", ['post' => $posts, "token" => $token]);
        } else {
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
        exit;
        }
    }
    public function mostrarForm() //vista formulario para subir post 
    {
        if (Authentication::isUserLogged()) {
            $comunidadModel = new ComunidadModel();
            $idUsuario = $_SESSION['user']['idUsuario'];
            $comunidades = $comunidadModel->getComunidadesUnido($idUsuario);

            //var_dump($comunidades);exit;
            ViewController::show("views/post/crearPost.php", ["comunidades" => $comunidades]);
            exit;
        } else {
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
        exit;
        }
    }
    public function subirPost() //subir un post desde el formulario crearPost.php
    {
        if (Authentication::isUserLogged()) {
            $_SESSION['cambioVista'] = "";
            $postModel = new PostModel();
            $idTema = $_POST['idTema'] ?? NULL;
            $titulo = $_POST['titulo'];
            $contenido = $_POST['contenido'];
            $idComunidad = $_POST['comunidad'] ?? NULL;
            $idUsuario = $_SESSION['user']['idUsuario'];
            $archivo = $_FILES['archivo'] ?? NULL;
            $fileType = $_FILES['archivo']['type'] ?? NULL;
            $video = NULL;
            $imagen = NULL;
            $tipoPost = NULL;
            if ($idTema == NULL) {
                $tipoPost = "normal";
            } else {
                $tipoPost = "comunidad";
            }
            if ($tipoPost == "normal") {
                $idComunidad = NULL;
            }

            if ($archivo != NULL) {
                if (strpos($fileType, 'video') !== false) {
                    $videoUploader = new VideoUploader();
                    $video = $videoUploader->subirVideo($archivo);
                } elseif (strpos($fileType, 'image') !== false) {
                    $imagenUploader = new ImageUploader();
                    $imagen = $imagenUploader->subirImagen($archivo);
                } else {
                    header("location:" . Parameters::$BASE_URL . "Post/mostrarForm");
                    echo "El archivo no es ni video ni imagen.";
                    exit;
                }
            } else {
                $video = NULL;
                $imagen = NULL;
            }

            $post = $postModel->subirPost($titulo, $contenido, $idUsuario, $idTema, $tipoPost, $video, $imagen, $idComunidad);
            if($post){
                header('Location:' . Parameters::$BASE_URL . "Post/home");
                exit;
            }else{
                header("location:" . Parameters::$BASE_URL . "Post/mostrarForm");
                exit;
            }
        } else {
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
        }
    }
    public function home() // home 
    {
        if (Authentication::isUserLogged()) {
            $postModel = new PostModel();
            $generarToken = new HelpersGenerarToken();
            $_SESSION['cambioVista'] = "verPostRecientes";

            $idUsuario = $_SESSION['user']['idUsuario'];
            $pagina = 1;
            $postPorPagina = 15;
            $token = [];
            $posts = $postModel->getPostHome($idUsuario, $pagina, $postPorPagina);
            foreach ($posts as $post) {
                if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                    $token[$post['id_post']] = $generarToken->generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                } else {
                    $post['jwt_token'] = null;
                }
            }


            ViewController::show("views/post/home.php", ['post' => $posts, "token" => $token]);
        } else {
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
        }
    }
    public function All() // All 
    {
        if (Authentication::isUserLogged()) {
            $_SESSION['cambioVista'] = "verPostRecientes";
            $postModel = new PostModel();
            $generarToken = new HelpersGenerarToken();
            $idUsuario = $_SESSION['user']['idUsuario'];
            $pagina = 1;
            $postPorPagina = 15;
            $token = [];
            $posts = $postModel->getAllPost($idUsuario, $pagina, $postPorPagina);
            foreach ($posts as $post) {
                if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                    $token[$post['id_post']] = $generarToken->generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                } else {
                    $post['jwt_token'] = null;
                }
            }

            ViewController::show("views/post/all.php", [
                'post' => $posts,
                "token" => $token
            ]);
        } else {
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
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
            $generarToken = new HelpersGenerarToken();

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
                echo json_encode(['success' => false, 'message' => 'Ocurrio un error inesperado']);
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
                            $token[$post['id_post']] = $generarToken->generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
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
                            $token[$post['id_post']] = $generarToken->generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
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
                            $token[$post['id_post']] = $generarToken->generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                        } else {
                            $post['jwt_token'] = null;
                        }
                    }
                    break;

                default:
                    echo json_encode(['success' => false, 'message' => 'Ocurrio un error inesperado (145 postContr)']);
                    exit;
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
    public function borrarPostRecientes()
    {
        unset($_SESSION['post'][$_SESSION['user']['idUsuario']]);
        header("location:" . Parameters::$BASE_URL);
        exit;
    }
}
