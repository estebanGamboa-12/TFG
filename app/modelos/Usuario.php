<?php

class Usuario
{
    private $conexion;
    private $usuario;
    private $post;

    public function __construct()
    {
        $this->conexion = Conectar::conexion();
        $this->usuario = array();
        $this->post = array();
    }

    public function iniciarSesion()
    {
        $nombre = $_REQUEST["nombre"];
        $contrasena = $_REQUEST["contrasena"];
        try {


            $sql = "SELECT id, nombre,contraseña, imagen_logo_usuario FROM usuarios WHERE nombre=:nombre and contraseña=:contrasena";


            $consulta = $this->conexion->prepare($sql);

            // Vincula los parámetros
            $consulta->bindParam(':nombre', $nombre);
            $consulta->bindParam(':contrasena', $contrasena);

            $consulta->execute();
            while ($dato = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $this->usuario = $dato;
            }

            if ($consulta->rowCount() > 0) {
                $_SESSION['nombre'] = $_REQUEST['nombre'];
                $_SESSION["imagen_logo_usuario"] = $this->usuario['imagen_logo_usuario'];
                $_SESSION["id"] = $this->usuario['id'];
                //1º sql= saca todos los post para logeado.php

                $sql1 = "SELECT u.nombre,u.imagen_logo_usuario,p.titulo,p.fecha_creacion,p.contenido,p.imagen,p.video ,p.tipo_post
            FROM post p
             JOIN usuarios u ON p.id_usuario=u.id; ";
                $consulta1 = $this->conexion->prepare($sql1);
                $consulta1->execute();

                while ($dato = $consulta1->fetch(PDO::FETCH_ASSOC)) {
                    $this->post[] = $dato;
                }
                /*var_dump($this->post);
             exit;*/
                return $this->post;
            } else {
                header("Location: index.php?ctl=home&error=1");
                exit;
            }
        } catch (Exception $e) {
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
            $consula = $this->conexion->prepare($sql);
            $consula->bindParam(":correo", $_POST['email']);
            $consula->execute();
            $resultado = $consula->fetchAll();
            if (empty($resultado)) {

                $imagen = "administrador2.png";
                $contrasena = password_hash($_POST['contraseña'], PASSWORD_BCRYPT); //contraseña hasheada
                $sql2 = "INSERT INTO usuarios (nombre, apellido, correo, contraseña, imagen_logo_usuario) 
        VALUES (:nombre, :apellido, :correo, :contrasena, :imagen_logo_usuario)";
                $consulta = $this->conexion->prepare($sql2);
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
        } catch (Exception $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" .  $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function cerrar_conexion()
    {
        $this->conexion = NULL;
    }
}
