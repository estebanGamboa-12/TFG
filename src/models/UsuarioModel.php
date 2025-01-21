<?php
namespace admin\foro\Models;

use admin\foro\Config\Parameters;

class UsuarioModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->tabla="usuarios";
    }

    public function buscarUsuarioPorNombre($nombre)
    {
        try {

          $sql = "SELECT * FROM {$this->tabla} WHERE nombre=:nombre ";
            $consulta = $this->conn->prepare($sql);
            // Vincula los parámetros
            $consulta->bindParam(':nombre', $nombre);
            $consulta->execute();
            $resultado=$consulta->fetch(\pdo::FETCH_ASSOC);
            if ($consulta->rowCount() > 0) {
                $_SESSION['user'] = [
                    "idUsuario"=>$resultado['id_usuario'],
                    'nombre' => $resultado['nombre'], // O de cualquier otro origen, como $resultado['nombre']
                    'imagen_logo_usuario' => $resultado['imagen_logo_usuario'],
                ];
                  return $resultado;
            } else {
                return $consulta->rowCount();
            }
        } catch (\Exception $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" .  $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function comprobarUsuario($nombre)
    {
        try {
          $sql = "SELECT * FROM {$this->tabla} WHERE nombre=:nombre ";
            $consulta = $this->conn->prepare($sql);
            // Vincula los parámetros
            $consulta->bindParam(':nombre', $nombre);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                  return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" .  $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }

   public function registrarUsuario($nombre,$apellido,$email,$contrasena,$imagen)
    {
        try {
                $sql = "INSERT INTO usuarios ( nombre, apellido, correo, contraseña, imagen_logo_usuario, fecha_unido) 
        VALUES (:nombre, :apellido, :correo, :contrasena, :imagen_logo_usuario, current_timestamp())";
                $consulta = $this->conn->prepare($sql);
                $consulta->bindParam(":nombre", $nombre);
                $consulta->bindParam(":apellido", $apellido);
                $consulta->bindParam(":correo", $email);
                $consulta->bindParam(":contrasena", $contrasena);
                $consulta->bindParam(":imagen_logo_usuario", $imagen);

                return  $consulta->execute();
        } catch (\Exception $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" .  $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function usuarioPorId($idUsuario ){
        try{
            $sql="SELECT *  FROM usuarios WHERE id_usuario=:idUsuario";
            $consulta=$this->conn->prepare($sql);
            $consulta->bindParam(":idUsuario",$idUsuario);
            $consulta->execute();
            $resultado=$consulta->fetch(\PDO::FETCH_ASSOC);
            return $resultado;
       } catch (\Exception $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" .  $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function usuarioPorNombre($nombre){
        try{
            $sql="SELECT *  FROM usuarios WHERE nombre=:nombre";
            $consulta=$this->conn->prepare($sql);
            $consulta->bindParam(":nombre",$nombre);
            $consulta->execute();
            $resultado=$consulta->fetch(\PDO::FETCH_ASSOC);
            return $resultado;
       } catch (\Exception $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" .  $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function datosUsuario($idUsuario){
        try{
            $sql="SELECT 
    (SELECT COUNT(*) FROM `comentarios` WHERE id_usuario = :idUsuario) AS comentariosTotales,
    (SELECT COUNT(*) FROM `post` WHERE id_usuario = :idUsuario) AS postsTotales;
";
            $consulta=$this->conn->prepare($sql);
            $consulta->bindParam(":idUsuario",$idUsuario);
            $consulta->execute();
            $resultado=$consulta->fetch(\PDO::FETCH_ASSOC);
            return $resultado;
       } catch (\Exception $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" .  $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
}
