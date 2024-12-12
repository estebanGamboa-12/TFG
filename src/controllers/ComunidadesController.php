<?php

namespace admin\foro\Controllers;

use admin\foro\Helpers\Authentication;
use admin\foro\Helpers\ImageUploader;
use admin\foro\Models\ComunidadesModel;
use admin\foro\Models\ComunidadModel;
use admin\foro\Models\MembresiaModel;
use admin\foro\Models\PostModel;
use admin\foro\Models\TemaModel;
use Firebase\JWT\JWT;

class ComunidadesController
{

    public function explorar()
    {
        if (Authentication::isUserLogged()) {

            $comunidadesModel = new ComunidadModel();
            $membresiasModel = new MembresiaModel();
            $comunidades = $comunidadesModel->getAll();
            $membresias = [];
            $token = [];
            $idUsuario = $_SESSION['user']['idUsuario'];

            foreach ($comunidades as  $indice => $contenido) {
                $membresiasComunidad = $membresiasModel->getNumeroMiembros($contenido['id_comunidad']);
                $membresias[$contenido['id_comunidad']] = $membresiasComunidad;
                $token[$contenido['id_comunidad']] = self::generarToken($idUsuario, $contenido['id_comunidad'], NULL);
            }

            ViewController::show("views/comunidades/explorarComunidades.php", [
                'comunidades' => $comunidades,
                "membresias" => $membresias,
                "tokens" => $token
            ]);
        } else {
            ViewController::showError(403);
        }
    }

    public function verComunidad()
    {
        if (Authentication::isUserLogged()) {
            $_SESSION['cambioVista'] = "perfilComunidades";
            $comunidadesModel = new ComunidadModel();
            $postModel = new PostModel();
            $_SESSION['comunidadVer'] = $_GET['nombreComunidad'];
            $token = [];
            $idUsuario = $_SESSION['user']['idUsuario'];
            $nombreComunidad = $_GET['nombreComunidad'];
            $comunidad = $comunidadesModel->comunidadesPorNombre($nombreComunidad);
            $idComunidad = $comunidad['id_comunidad'];
            $posts = $postModel->postPorComunidad($idUsuario, $idComunidad);
            foreach ($posts as $post) {
                if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                    $token[$post['id_post']] = self::generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                } else {
                    $post['jwt_token'] = null;
                }
            }
            ViewController::show("views/comunidades/verComunidad.php", [
                "post" => $posts,
                "comunidad" => $comunidad,
                "token" => $token,

            ]);
        } else {
            ViewController::showError(403);
        }
    }
    public function VistaCrearComunidad()
    {
        $temasModel = new TemaModel();
        $temas = $temasModel->getTemas();
        ViewController::show("views/comunidades/crearComunidad.php", ["temas" => $temas]);
        $_SESSION['cambioVista'] = "";
        exit;
    }

    public function crearComunidad()
    {
        if (Authentication::isUserLogged()) {
            $comunidadesModel = new ComunidadModel();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $imagen = $_FILES["imagen"];
            $temas = $_POST['temas'];
            $idUsuario = $_SESSION['user']["idUsuario"];
            $subirImange= new ImageUploader();
            $nombreImagen=$subirImange->subirImagen($imagen);
            var_dump($nombreImagen);
            exit;
            $comprobacion = $comunidadesModel->insertarComunidad($idUsuario, $nombre, $descripcion, $imagen);
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
