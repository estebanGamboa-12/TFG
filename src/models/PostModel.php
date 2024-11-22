<?php

namespace admin\foro\Models;

class PostModel extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->tabla = "post";
    }
    public function getPostPopular($usuario) //parte popular
    {
        // saca todos los post en orden segun los votos, saber si esta unido o no y no mostrar sus post 
        $sql="SELECT 
    p.id_comunidad, 
    u.id_usuario, 
    u.nombre,
    u.imagen_logo_usuario,
    c.imagen AS image_comunidad, 
    p.titulo,
    p.fecha_creacion, 
    p.contenido,
    p.imagen, 
    p.video, 
    p.tipo_post, 
    COUNT(v.id_post) AS votos, 
    CASE 
        WHEN m.id_usuario IS NOT NULL THEN '1' 
        ELSE '0' 
    END AS esta_unido 
FROM 
    post p
JOIN 
    usuarios u ON p.id_usuario = u.id_usuario 
LEFT JOIN 
    votos v ON p.id_post = v.id_post 
LEFT JOIN 
    membresias m ON m.id_usuario =:idUsuario AND m.id_comunidad = p.id_comunidad
JOIN 
    comunidades c ON c.id_comunidad = p.id_comunidad 
WHERE 
    p.id_usuario !=:idUsuario
GROUP BY 
    p.id_post 
ORDER BY 
    votos DESC;
        ";
        try {
            //consulta1
            $consulta1 = $this->conn->prepare($sql);
            $consulta1->bindParam(":idUsuario", $usuario);
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
    public function getAllPost($usuario) //parte popular
    {
        // saca todos los post
        $sql1 = "SELECT p.id_comunidad, u.id_usuario, u.nombre,
       u.imagen_logo_usuario,
       p.titulo,
       p.fecha_creacion,
       p.contenido,
       p.imagen,
       p.video,
       p.tipo_post,
      c.imagen As image_comunidad,
       CASE 
           WHEN m.id_comunidad IS NOT NULL THEN 1  -- Si el usuario está en la comunidad
           ELSE 0  -- Si el usuario no está en la comunidad
       END AS esta_unido
FROM post p
JOIN usuarios u ON p.id_usuario = u.id_usuario
LEFT JOIN membresias m ON m.id_usuario = :idUsuario AND m.id_comunidad = p.id_comunidad; ";

        try {
            $consulta = $this->conn->prepare($sql1);
            $consulta->bindParam(":idUsuario", $usuario);
            $consulta->execute();

            $dato = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $dato;
            exit;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function getPostHome($id_usuario) //parte home
    {
        try {
            //1ºPosts de las comunidades a las que el usuario está unido
            //2ºPosts de las comunidades a las que el usuario NO está unido(sacamos unas pocas para que salgan recomendadas)
            $sql = "
        (
            SELECT p.id_comunidad,c.imagen As image_comunidad, u.id_usuario ,u.nombre, u.imagen_logo_usuario, p.id_post, p.titulo, p.contenido, p.fecha_creacion, p.tipo_post, 
                   c.id_comunidad , c.nombre AS comunidad_nombre, 1 AS esta_unido
            FROM post p
            JOIN comunidades c ON p.id_comunidad = c.id_comunidad
            JOIN usuarios u ON u.id_usuario = p.id_usuario
            JOIN membresias m ON c.id_comunidad = m.id_comunidad
            WHERE m.id_usuario = :idUsuario
        )
        UNION ALL
        (
            SELECT p.id_comunidad,c.imagen As image_comunidad,u.id_usuario, u.nombre, u.imagen_logo_usuario, p.id_post, p.titulo, p.contenido, p.fecha_creacion, p.tipo_post, 
                   c.id_comunidad , c.nombre AS comunidad_nombre, 0 AS esta_unido
            FROM post p
            JOIN comunidades c ON p.id_comunidad = c.id_comunidad
            JOIN usuarios u ON u.id_usuario = p.id_usuario
            WHERE c.id_comunidad NOT IN (SELECT id_comunidad FROM membresias m WHERE m.id_usuario = :idUsuario)
            LIMIT 5
        )
        ORDER BY fecha_creacion DESC;
    ";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idUsuario", $id_usuario);
            $consulta->execute();

            $dato = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $dato;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function subirPost($titulo, $contenido, $id_usuario, $id_tema, $tipo_post)
    {
        // Preparar la consulta SQL
        $sql = "INSERT INTO `post` (id_post, titulo, contenido, fecha_creacion, imagen, video, id_usuario, id_comunidad, id_tema, tipo_post) 
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
    public function getPostPopularNoLogeado() //parte popular no logeado
    {
        // saca todos los post en orden segun los votos 
        $sql = "SELECT p.id_comunidad, u.nombre, u.imagen_logo_usuario, p.titulo, p.fecha_creacion, p.contenido, p.imagen, p.video,
         p.tipo_post, COUNT(v.id_post) AS votos
          FROM post p JOIN usuarios u ON p.id_usuario = u.id_usuario
           LEFT JOIN votos v ON p.id_post = v.id_post
             GROUP BY p.id_post 
             ORDER BY votos DESC;  ";

        try {
            $consulta = $this->conn->prepare($sql);
            $consulta->execute();

            $dato = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $dato;
            exit;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function cerrar_conexion()
    {
        $this->conn = NULL;
    }
}
