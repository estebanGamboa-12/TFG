<?php

require_once "configuracion.php";
class Conectar
{
    public static function conexion()
    {
        try {
            $conexion = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . ';port=' . PORT . ';charset=' . CHARSET, USERNAME, PASSWORD);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            exit;
        }
        return $conexion;
    }
}
?>