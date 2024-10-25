<?php

class Usuario
{
    private $conexion;
    private $usuario;

    public function  __construct()
    {
        $this->conexion = Conectar::conexion();
    }

    public function iniciarSesion()
    {
        $nombre =  $_REQUEST["nombre"];
        $contrasena = $_REQUEST["contrasena"];
        $sql = "SELECT nombre,contraseña FROM usuarios WHERE nombre=:nombre and contraseña=:contrasena";

        $consulta = $this->conexion->prepare($sql);

        // Vincula los parámetros
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':contrasena', $contrasena);
        
        
    }
}
