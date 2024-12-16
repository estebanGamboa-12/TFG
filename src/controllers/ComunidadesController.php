<?php

namespace admin\foro\Controllers;

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;
use admin\foro\Helpers\GenerarToken as HelpersGenerarToken;
use admin\foro\Helpers\ImageUploader;
use admin\foro\Models\ComunidadesModel;
use admin\foro\Models\ComunidadModel;
use admin\foro\Models\MembresiaModel;
use admin\foro\Models\PostModel;
use admin\foro\Models\TemaModel;
use admin\foro\Models\temasComunidadModel;
use Firebase\JWT\JWT;
use GenerarToken;

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
            $generarToken=new HelpersGenerarToken();


            $idUsuario = $_SESSION['user']['idUsuario'];

            foreach ($comunidades as  $indice => $contenido) {
                $membresiasComunidad = $membresiasModel->getNumeroMiembros($contenido['id_comunidad']);
                $membresias[$contenido['id_comunidad']] = $membresiasComunidad;
                $token[$contenido['id_comunidad']] = $generarToken->generarToken($idUsuario, $contenido['id_comunidad'], NULL);
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
            $generarToken=new HelpersGenerarToken();
            $_SESSION['comunidadVer'] = $_GET['nombreComunidad'];
            $token = [];
            $idUsuario = $_SESSION['user']['idUsuario'];
            $nombreComunidad = $_GET['nombreComunidad'];
            $comunidad = $comunidadesModel->comunidadesPorNombre($nombreComunidad);
            $idComunidad = $comunidad['id_comunidad'];
            $posts = $postModel->postPorComunidad($idUsuario, $idComunidad);
            foreach ($posts as $post) {
                if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                    $token[$post['id_post']] = $generarToken->generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
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
            $errores = [];
            $comunidadesModel = new ComunidadModel();
            $temasComunidadModel = new temasComunidadModel();
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $imagen = $_FILES["imagen"];
            $temas = $_POST['temas'];
            $idUsuario = $_SESSION['user']["idUsuario"];
            $subirImange = new ImageUploader();

            // Validaciones
            if (empty($nombre)) {
                $errores[] = "El nombre es obligatorio.";
            }

            if (empty($descripcion)) {
                $errores[] = "La descripción es obligatoria.";
            }
            if (empty($temas)) {
                $errores[] = "Debes escoger un tema al menos.";
            }
            // Validación de la imagen
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
            $extensionImagen = pathinfo($imagen['name'], PATHINFO_EXTENSION);

            if ($imagen['error'] !== UPLOAD_ERR_OK) {
                $errores[] = "Error al subir la imagen.";
            } elseif (!in_array($extensionImagen, $extensionesPermitidas)) {
                $errores[] = "La imagen debe ser de tipo JPG, JPEG, PNG o GIF.";
            }

            if (empty($errores)) {
                $nombreImagen = $subirImange->subirImagen($imagen);
                $comprobacion = $comunidadesModel->insertarComunidad($idUsuario, $nombre, $descripcion, $nombreImagen);
                $comunidad = $temasComunidadModel->obtenerUltimaComunidad();
                $idComunidad=$comunidad['id_comunidad'];
                if ($comprobacion) {
                    foreach ($temas as $tema) {
                        $idTema = intval($tema);
                        $comprobacion = $temasComunidadModel->insertarTemasEnComunidad($idTema, $idComunidad);
                    }
                    if($comprobacion){
                        $_SESSION['mensaje'] = "Se ha creado correctamente la comunidad";
                        header("location:" . Parameters::$BASE_URL . "Post/home");
                    }else{
                        $errores[] = "Hubo un problema inesperado al crear la comunidad";
                        $_SESSION['errores'] = $errores;
                        header("location:" . Parameters::$BASE_URL . "Post/home");
                    }
                } else {
                    $errores[] = "Hubo un problema inesperado al crear la comunidad";
                    $_SESSION['errores'] = $errores;
                    header("location:" . Parameters::$BASE_URL . "Post/home");
                }
            } else {
                // Si hay errores, guardarlos en la sesión y redirigir
                $_SESSION['errores'] = $errores;
                header("location:" . Parameters::$BASE_URL . "Post/home");
            }
        }
    }

   
}
