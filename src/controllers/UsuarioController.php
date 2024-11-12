<?php
namespace admin\foro\Controllers;

use admin\foro\Config\Parameters;
use admin\foro\Models\UsuarioModel;

class UsuarioController
{

    public function iniciarSesion()
    {
        $usuarioModel = new UsuarioModel();
        $nombre=$_REQUEST['nombre'];
        $contrasena=$_REQUEST['contrasena'];
        $datos = $usuarioModel->iniciarSesion($nombre,$contrasena);
        var_dump($_SESSION);

        header('Location: ' . Parameters::$BASE_URL . 'Post/index');

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
}
