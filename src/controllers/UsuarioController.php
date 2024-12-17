<?php

namespace admin\foro\Controllers;

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;
use admin\foro\Helpers\GenerarToken as HelpersGenerarToken;
use admin\foro\Helpers\ImageUploader;
use admin\foro\Models\PostModel;
use admin\foro\Models\UsuarioModel;
use Firebase\JWT\JWT;

class UsuarioController
{
    public function cerrarSesion()
    {
        unset($_SESSION['user']);
        header("location:" . Parameters::$BASE_URL);
    }
    public function mostrarVetananCerrarSesion()
    {
        $_SESSION['cambioVista'] = "cerrarSesion";
    }
    public function verFormularioIniciarSesion()
    {
        if (Authentication::isUserLogged()) {
            header("Location: " . Parameters::$BASE_URL . "Post/home");
            exit;
        }
        ViewController::show("views/usuario/formularioIniciarSesion.php");
        exit;
    }
    public function mostrarFormularioRegistrar()
    {
        if (Authentication::isUserLogged()) {
            header("Location: " . Parameters::$BASE_URL . "Post/home");
            exit;
        }
        ViewController::show("views/usuario/formularioRegistrarUsuario.php");
        exit;
    }

    public function iniciarSesion()
    {
        $usuarioModel = new UsuarioModel();
        $nombre = $_REQUEST['nombre'];
        $contrasena = $_REQUEST['contraseña'];
        $datos = $usuarioModel->iniciarSesion($nombre, $contrasena);
        if ($datos == 0) {
            $errores = [];
            $errores = "El usuario o la contraseña son incorrectas";
            $_SESSION['errores'] = $errores;
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
        }
        if ($datos) {
            header('Location: ' . Parameters::$BASE_URL . 'Post/home');
            exit;
        }
    }
    public function registrarUsuario()
    {
        $usuarioModel = new UsuarioModel();
        $imagenUploader = new ImageUploader();
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['correo'];
        $contrasena = $_POST['contraseña'];
        $repetirContrasena = $_POST['repetir_contraseña'];
        $imagen = $_FILES['imagen'];

        if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['correo']) && !empty($_POST['contraseña']) && !empty($_POST['repetir_contraseña'])) {
            if ($_POST['contraseña'] === $_POST['repetir_contraseña']) {
                $imagen = $imagenUploader->subirImagen($imagen);
                $contrasena = password_hash($_REQUEST['contraseña'], PASSWORD_DEFAULT);
                $comprobar = $usuarioModel->registrarUsuario($nombre, $apellido, $email, $contrasena, $imagen);
                if ($comprobar) {
                    header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
                    exit;
                } else {
                    //no se pudo registrar el usuario
                    header("location:" . Parameters::$BASE_URL . "Usuario/mostrarFormularioRegistrar");
                    exit;
                }
            } else {
                //no coinciden las contraseñas
                header("location:" . Parameters::$BASE_URL . "Usuario/mostrarFormularioRegistrar");
                exit;
            }
        } else {
            //estan vacio algun campo
            header("location:" . Parameters::$BASE_URL . "Usuario/mostrarFormularioRegistrar");
            exit;
        }
    }

    public function verUsuario()
    {
        $_SESSION['cambioVista'] = "perfilUsuario";
        $usuarioModel = new UsuarioModel();
        $postModel = new PostModel();
        $generarToken = new HelpersGenerarToken();
        $nombre = $_GET['nombre'];
        $token = [];
        $usuario = $usuarioModel->usuarioPorNombre($nombre);
        $idUsuarioPerfil = $usuario['id_usuario'];
        $idUsuarioVisita = $_SESSION['user']['idUsuario'];
        $_SESSION['usuarioVer'] = $usuario;


        $posts = $postModel->postPorUsuario($idUsuarioPerfil, $idUsuarioVisita);
        foreach ($posts as $post) {
            $idUsuario = $_SESSION['user']['idUsuario'];
            if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                $token[$post['id_post']] = $generarToken->generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
            } else {
                $post['jwt_token'] = null;
            }
        }
        ViewController::show("views/usuario/verUsuario.php", ["post" => $posts, "token" => $token, "usuario" => $usuario]);
    }
}
