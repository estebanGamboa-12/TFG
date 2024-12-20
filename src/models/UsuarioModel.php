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

    public function iniciarSesion($nombre,$contrasena)
    {
        try {

            $sql = "SELECT id_usuario, nombre,contraseña, imagen_logo_usuario FROM {$this->tabla} WHERE nombre=:nombre and contraseña=:contrasena";


            $consulta = $this->conn->prepare($sql);

            // Vincula los parámetros
            $consulta->bindParam(':nombre', $nombre);
            $consulta->bindParam(':contrasena', $contrasena);

            $consulta->execute();
            $resultado=null;
            while ($dato = $consulta->fetch(\PDO::FETCH_ASSOC)) {
                $resultado = $dato;
            }

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

    public function registrarUsuario()
    {
        //var_dump($_POST);
        try {

            $sql = "SELECT correo from usuarios where correo=:correo";
            $consula = $this->conn->prepare($sql);
            $consula->bindParam(":correo", $_POST['email']);
            $consula->execute();
            $resultado = $consula->fetchAll();
            if (empty($resultado)) {

                $imagen = "administrador2.png";
                $contrasena = password_hash($_POST['contraseña'], PASSWORD_BCRYPT); //contraseña hasheada
                $sql2 = "INSERT INTO usuarios (nombre, apellido, correo, contraseña, imagen_logo_usuario) 
        VALUES (:nombre, :apellido, :correo, :contrasena, :imagen_logo_usuario)";
                $consulta = $this->conn->prepare($sql2);
                $consulta->bindParam(":nombre", $_POST['nombre']);
                $consulta->bindParam(":apellido", $_POST['apellido']);
                $consulta->bindParam(":correo", $_POST['email']);
                $consulta->bindParam(":contrasena", $contrasena);
                $consulta->bindParam(":imagen_logo_usuario", $imagen);

                $consulta->execute();
            } else {
                //echo "existe el correo <br>";
                header("location:index.php");
                exit;
            }
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
