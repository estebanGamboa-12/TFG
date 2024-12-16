<?php

namespace admin\foro\Controllers;

use admin\foro\Config\Parameters;
use admin\foro\Helpers\GenerarToken as HelpersGenerarToken;
use admin\foro\Models\PostModel;
use admin\foro\Models\UsuarioModel;
use Firebase\JWT\JWT;

class UsuarioController
{
    public function cerrarSesion()
    {
        unset($_SESSION['user']);
        header("location:" . Parameters::$BASE_URL . "Post/popularNoLogeado");
    }
    public function mostrarVetananCerrarSesion()
    {
        $_SESSION['cambioVista'] = "cerrarSesion";
    }

    public function iniciarSesion()
    {
        $usuarioModel = new UsuarioModel();
        $nombre = $_REQUEST['nombre'];
        $contrasena = $_REQUEST['contrasena'];
        $datos = $usuarioModel->iniciarSesion($nombre, $contrasena);

        header('Location: ' . Parameters::$BASE_URL . 'Post/home');
    }
    public function registrarUsuarios()
    {
        $usuarioModel = new UsuarioModel();
        var_dump($_POST);
        exit;

        if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['email']) && !empty($_POST['contraseña']) && !empty($_POST['repetir_contraseña'])) {
            if ($_POST['contraseña'] === $_POST['repetir_contraseña']) {
                $datos = $usuarioModel->registrarUsuario();
                header("location:index.php");
                exit;
            } else {
                //no coinciden las contraseñas
                header("location:index.php");
                exit;
            }
        } else {
            //estan vacio algun cammpo
            header("location:index.php");
            exit;
        }
    }
    public function verUsuario()
    {
        $_SESSION['cambioVista'] = "perfilUsuario";
        $usuarioModel = new UsuarioModel();
        $postModel = new PostModel();
        $generarToken=new HelpersGenerarToken();
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
                $token[$post['id_post']] =$generarToken->generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);              
            } else {
                $post['jwt_token'] = null;
            }
        }
        ViewController::show("views/usuario/verUsuario.php", ["post" => $posts, "token" => $token, "usuario" => $usuario]);
    }
   
}
