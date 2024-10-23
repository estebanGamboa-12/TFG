<?php
require_once "Configuracion.php";
class Conectar{
    public static function conexion(){
        try {
           
            $conexion = new PDO('mysql:host=' . Config::$host. ';dbname=' . Config::$database . ';port=' . Config::$port . ';charset=' . Config::$charset, Config::$username, Config::$password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error: " . $e->getFile();
            echo "<br>Línea del error: " . $e->getLine();
            exit;
        }         
        return $conexion;
    }
}
?>