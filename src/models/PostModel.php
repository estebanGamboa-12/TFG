<?php

namespace admin\foro\Models;

class PostModel extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->tabla = "post";
    }

    public function obtenerPostAleatorios()
    { //modificar la sql , de momento de prueba 
        $sql = "SELECT u.nombre,u.imagen,p.titulo,p.fecha_creacion,p.contenido,p.imagen,p.video ,p.tipo_post FROM post p JOIN usuarios u ON p.id_usuario=u.id;  ";
        try {
            $consulta = $this->conn->prepare($sql);
            $consulta->execute();
            $dato = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $dato;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function getPostPopular()//parte popular
    {
        // saca todos los post
        $sql1 = "SELECT u.nombre,u.imagen_logo_usuario,p.titulo,p.fecha_creacion,p.contenido,p.imagen,p.video ,p.tipo_post
         FROM post p
          JOIN usuarios u ON p.id_usuario=u.id; ";

        try {
            //consulta1
            $consulta1 = $this->conn->prepare($sql1);
            $consulta1->execute();

            $dato = $consulta1->fetchAll(\PDO::FETCH_ASSOC);
            return $dato;
            exit;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function getPostHome($id_usuario)//parte home
    {
        try {
        // saca todos los 
        //1ºPosts de las comunidades a las que el usuario está unido
        //2ºPosts de las comunidades a las que el usuario NO está unido(sacamos unas pocas para que salgan recomendadas)
        $sql = "
        (
            SELECT u.nombre, u.imagen_logo_usuario, p.id, p.titulo, p.contenido, p.fecha_creacion, p.tipo_post, 
                   c.id AS comunidad_id, c.nombre AS comunidad_nombre, 1 AS esta_unido
            FROM post p
            JOIN comunidades c ON p.id_comunidad = c.id
            JOIN usuarios u ON u.id = p.id_usuario
            JOIN membresias m ON c.id = m.id_comunidad
            WHERE m.id_usuario = :idUsuario
        )
        UNION ALL
        (
            SELECT u.nombre, u.imagen_logo_usuario, p.id, p.titulo, p.contenido, p.fecha_creacion, p.tipo_post, 
                   c.id AS comunidad_id, c.nombre AS comunidad_nombre, 0 AS esta_unido
            FROM post p
            JOIN comunidades c ON p.id_comunidad = c.id
            JOIN usuarios u ON u.id = p.id_usuario
            WHERE c.id NOT IN (SELECT id_comunidad FROM membresias m WHERE m.id_usuario = :idUsuario)
            LIMIT 5
        )
        ORDER BY fecha_creacion DESC;
    ";
    

       
            //consulta1
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idUsuario",$id_usuario);
            $consulta->execute();

            $dato = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $dato;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function subirPost($titulo,$contenido,$id_usuario,$id_tema,$tipo_post)
    {
        // Preparar la consulta SQL
        $sql = "INSERT INTO `post` (id, titulo, contenido, fecha_creacion, imagen, video, id_usuario, id_comunidad, id_tema, tipo_post) 
        VALUES (NULL, :titulo, :contenido, CURRENT_TIMESTAMP(), NULL, NULL, :id_usuario, NULL, :id_tema, :tipo_post);";

        $consulta = $this->conn->prepare($sql);

        // Bind de los parámetros
        $consulta->bindParam(':titulo', $titulo);
        $consulta->bindParam(':contenido', $contenido);
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_tema', $id_tema);
        $consulta->bindParam(':tipo_post', $tipo_post);

        // Ejecuta la consulta
        if ($consulta->execute()) {
            echo "Post insertado correctamente.";
        } else {
            echo "Error al insertar el post.";
        }
    }
    public function cerrar_conexion()
    {
        $this->conn = NULL;
    }
}
