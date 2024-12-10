<?php

namespace admin\foro\Models;

class PostModel extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->tabla = "post";
    }
    public function getPostPopular($usuario, $pagina, $postPorPagina) //parte popular
    {
        // Calcular el OFFSET (desplazamiento)
        $offset = ($pagina - 1) * $postPorPagina;
        // saca todos los post en orden segun los votos, saber si esta unido o no y no mostrar sus post 
        $sql = "SELECT 
    p.id_post,
    p.id_comunidad,
     c.nombre AS nombre_comunidad,
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
    votos DESC
LIMIT :offset, :limit;
        ";
        try {
            //consulta1
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idUsuario", $usuario);
            $consulta->bindParam(":offset", $offset, \PDO::PARAM_INT);
            $consulta->bindParam(":limit", $postPorPagina, \PDO::PARAM_INT);
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
    public function getAllPost($usuario, $pagina, $postPorPagina)
    {
        // Calcular el OFFSET (desplazamiento)
        $offset = ($pagina - 1) * $postPorPagina;

        // Consulta SQL con LIMIT y OFFSET
        $sql1 = "SELECT 
                    p.id_post,
                    p.id_comunidad, 
                     c.nombre AS nombre_comunidad,
                    u.id_usuario, 
                    u.nombre, 
                    u.imagen_logo_usuario, 
                    p.titulo, 
                    p.fecha_creacion, 
                    p.contenido, 
                    p.imagen, 
                    p.video, 
                    p.tipo_post, 
                    c.imagen AS image_comunidad, 
                    CASE 
                        WHEN m.id_comunidad IS NOT NULL THEN 1 
                        ELSE 0 
                    END AS esta_unido, 
                    COUNT(v.id_voto) AS votos  
                FROM post p
                JOIN usuarios u ON p.id_usuario = u.id_usuario
                LEFT JOIN membresias m ON m.id_usuario = :idUsuario AND m.id_comunidad = p.id_comunidad
                LEFT JOIN comunidades c ON c.id_comunidad = p.id_comunidad
                LEFT JOIN votos v ON v.id_post = p.id_post  
                GROUP BY 
                    p.id_post,  
                    p.id_comunidad, 
                     c.nombre ,
                    u.id_usuario, 
                    u.nombre, 
                    u.imagen_logo_usuario, 
                    p.titulo, 
                    p.fecha_creacion, 
                    p.contenido, 
                    p.imagen, 
                    p.video, 
                    p.tipo_post, 
                    c.imagen
                LIMIT :offset, :limit";

        try {
            // Preparar la consulta
            $consulta = $this->conn->prepare($sql1);

            // Vincular los parámetros
            $consulta->bindParam(":idUsuario", $usuario);
            $consulta->bindParam(":offset", $offset, \PDO::PARAM_INT);
            $consulta->bindParam(":limit", $postPorPagina, \PDO::PARAM_INT);

            // Ejecutar la consulta
            $consulta->execute();

            // Obtener los resultados
            $dato = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $dato;
        } catch (\PDOException $e) {
            // Manejo de errores
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function getPostHome($id_usuario, $pagina, $postPorPagina) //parte home
    {
        try {

            // Calcular el OFFSET (desplazamiento)
            $offset = ($pagina - 1) * $postPorPagina;
            //1ºPosts de las comunidades a las que el usuario está unido
            //2ºPosts de las comunidades a las que el usuario NO está unido(sacamos unas pocas para que salgan recomendadas)
            $sql = "
      (
    SELECT 
    	p.*,
        c.nombre AS nombre_comunidad,
        c.imagen AS image_comunidad, 
        u.id_usuario, 
        u.nombre, 
        u.imagen_logo_usuario, 
        c.id_comunidad, 
        c.nombre AS comunidad_nombre, 
        1 AS esta_unido,
        COUNT(v.id_voto) AS votos  
    FROM 
        post p
    JOIN 
        comunidades c ON p.id_comunidad = c.id_comunidad
    JOIN 
        usuarios u ON u.id_usuario = p.id_usuario
    JOIN 
        membresias m ON c.id_comunidad = m.id_comunidad
    LEFT JOIN 
        votos v ON v.id_post = p.id_post  
    WHERE 
        m.id_usuario = :idUsuario
    GROUP BY 
        p.id_post
)
UNION ALL
(
    SELECT 
    	p.*,
         c.nombre AS nombre_comunidad,
        c.imagen AS image_comunidad, 
        u.id_usuario, 
        u.nombre, 
        u.imagen_logo_usuario, 
        c.id_comunidad, 
        c.nombre AS comunidad_nombre, 
        0 AS esta_unido,
        COUNT(v.id_voto) AS votos  
    FROM 
        post p
    JOIN 
        comunidades c ON p.id_comunidad = c.id_comunidad
    JOIN 
        usuarios u ON u.id_usuario = p.id_usuario
    LEFT JOIN 
        votos v ON v.id_post = p.id_post  
    WHERE 
        c.id_comunidad NOT IN (SELECT id_comunidad FROM membresias m WHERE m.id_usuario = :idUsuario)
    GROUP BY 
        p.id_post
)
    LIMIT :offset, :limit;
    ";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idUsuario", $id_usuario);
            $consulta->bindParam(":offset", $offset, \PDO::PARAM_INT);
            $consulta->bindParam(":limit", $postPorPagina, \PDO::PARAM_INT);
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
    public function getPostPopularNoLogeado($pagina, $postPorPagina) //parte popular no logeado
    {
        // Calcular el OFFSET (desplazamiento)
        $offset = ($pagina - 1) * $postPorPagina;
        // saca todos los post en orden segun los votos 
        $sql = "SELECT p.id_comunidad, u.nombre, u.imagen_logo_usuario, p.titulo, p.fecha_creacion, p.contenido, p.imagen, p.video,
         p.tipo_post, COUNT(v.id_post) AS votos
          FROM post p JOIN usuarios u ON p.id_usuario = u.id_usuario
           LEFT JOIN votos v ON p.id_post = v.id_post
             GROUP BY p.id_post 
             ORDER BY votos DESC
            LIMIT :offset, :limit; 
             ";

        try {
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":offset", $offset, \PDO::PARAM_INT);
            $consulta->bindParam(":limit", $postPorPagina, \PDO::PARAM_INT);
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
    public function postPorUsuario($idUsuarioPerfil, $idUsuarioVisita)
    {
        try {
            $sql = "
            SELECT p.*, 
                   COUNT(v.id_voto) AS votos, 
                   C.nombre AS nombre_comunidad, 
                   C.imagen AS imagen_comunidad,
                   CASE 
                       WHEN m.id_usuario IS NOT NULL THEN 1 
                       ELSE 0
                   END AS esta_unido
            FROM post p
            JOIN usuarios u ON p.id_usuario = u.id_usuario
            LEFT JOIN votos v ON v.id_post = p.id_post
            LEFT JOIN comunidades c ON c.id_comunidad = p.id_comunidad
            LEFT JOIN membresias m ON m.id_usuario = :usuarioVisita AND m.id_comunidad = p.id_comunidad
            WHERE p.id_usuario = :usuarioPerfil
            GROUP BY p.id_post, c.id_comunidad
            ORDER BY p.id_post DESC
            LIMIT 1, 15;
            ";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":usuarioPerfil", $idUsuarioPerfil);
            $consulta->bindParam(":usuarioVisita", $idUsuarioVisita);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function postPorComunidad($idUsuario, $idComunidad)
    {
        try {
            $sql = "
        SELECT 
p.*,
COUNT(v.id_voto) AS votos,
u.nombre AS nombre_usuario,
u.imagen_logo_usuario ,
CASE
	WHEN m.id_usuario IS NOT NULL THEN 1
    ELSE 0
    END AS esta_unido
FROM post p 
JOIN usuarios u ON p.id_usuario=u.id_usuario
LEFT JOIN votos v ON v.id_post=p.id_post
LEFT JOIN comunidades c ON c.id_comunidad=p.id_comunidad
LEFT JOIN membresias m ON m.id_usuario=:idUsuario AND m.id_comunidad=p.id_comunidad
WHERE p.id_comunidad=:idComunidad
GROUP BY p.id_post,c.id_comunidad;
        ";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idUsuario", $idUsuario);
            $consulta->bindParam(":idComunidad", $idComunidad);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function postPorId($idPost)
    {
        try {
            $sql = "SELECT p.*,u.*,COUNT(v.id_voto) AS votos_totales 
        FROM post p 
        LEFT JOIN votos v ON v.id_post=p.id_post 
        JOIN usuarios u ON u.id_usuario=p.id_usuario
        WHERE p.id_post=:idPost; ";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idPost", $idPost);
            $consulta->execute();
            return $consulta->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
}
