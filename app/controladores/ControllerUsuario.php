<?php

class ControllerUsuario
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }
    public function iniciarSesion()
    {
        $m = new Usuario();
        $datos = $m->iniciarSesion();
        $m->cerrar_conexion();

        require_once "app/vistas/logeado.php";
    }
    public function registrarUsuarios()
    {
        $m = new Usuario();
        //var_dump($_POST);

        if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['email']) && !empty($_POST['contraseña']) && !empty($_POST['repetir_contraseña'])) {
            if ($_POST['contraseña'] === $_POST['repetir_contraseña']) {
                $datos = $m->registrarUsuario();
                $m->cerrar_conexion();
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
