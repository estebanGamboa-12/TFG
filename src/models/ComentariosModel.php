<?php

namespace admin\foro\Models;

class ComentariosModel extends Model
{


    public function __construct()
    {
        parent::__construct();
        $this->tabla = "comentarios";
    }
    public function comentariosDeUnPost($idPost)
    {
        // -- Comentarios principales 
        $sql1 = "
        SELECT c1.id_comentario, c1.contenido, c1.fecha_creacion, u1.nombre AS nombre_usuario_comentario, c1.id_post 
        FROM comentarios c1 
        LEFT JOIN usuarios u1 ON c1.id_usuario = u1.id_usuario WHERE c1.id_post = :id_post AND 
        c1.id_comentario_padre IS NULL
        ORDER BY c1.fecha_creacion DESC; ";

        // -- Subcomentarios
        $sql2 = "SELECT 
    c2.id_comentario AS subcomentario_id,
    c2.contenido AS subcomentario_contenido,
    c2.fecha_creacion AS subcomentario_fecha,
    u2.nombre AS nombre_usuario_subcomentario,
    c2.id_post AS subcomentario_post,
    c2.id_comentario_padre AS subcomentario_padre
FROM comentarios c2
LEFT JOIN usuarios u2 ON c2.id_usuario = u2.id_usuario
WHERE c2.id_post = :id_post AND c2.id_comentario_padre IS NOT NULL
ORDER BY c2.fecha_creacion DESC ;";
        try {
            $consulta1 = $this->conn->prepare($sql1);
            $consulta1->bindParam(":id_post", $idPost);
            $consulta1->execute();
            $comentariosPrincipales = $consulta1->fetchAll(\PDO::FETCH_ASSOC);
            $consulta2 = $this->conn->prepare($sql2);
            $consulta2->bindParam(":id_post", $idPost);
            $consulta2->execute();
            $subcomentarios  = $consulta2->fetchAll(\PDO::FETCH_ASSOC);
            return [
                'comentarios' => $comentariosPrincipales,
                'subcomentarios' => $subcomentarios
            ];
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function subirComentario($idPost, $comentario, $idUsuario)
    {
        $sql = "INSERT INTO comentarios
        (contenido, fecha_creacion, id_usuario, id_post, id_comentario_padre)
         VALUES (:comentario,CURRENT_TIMESTAMP(),:idUsuario,:idPost,NULL)";
        $consulta = $this->conn->prepare($sql);
        $consulta->bindParam(":idPost", $idPost);
        $consulta->bindParam(":comentario", $comentario);
        $consulta->bindParam(":idUsuario", $idUsuario);
        return $consulta->execute();
    }
    public function getComentario($idPost, $comentario, $idUsuario)
    {
        try {

            $sql = "SELECT o.*,u.nombre FROM comentarios o
    JOIN usuarios u ON u.id_usuario=o.id_usuario
     WHERE id_post = :idPost 
     AND contenido = :comentario 
     AND o.id_usuario = :idUsuario";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idPost", $idPost);
            $consulta->bindParam(":comentario", $comentario);
            $consulta->bindParam(":idUsuario", $idUsuario);
            $consulta->execute();
            $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);
            if ($resultado) {
                return $resultado;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function subirSubComentario($idPost,$idComentario, $comentario, $idUsuario)
    {
        $sql = "INSERT INTO comentarios
        (contenido, fecha_creacion, id_usuario, id_post, id_comentario_padre)
         VALUES (:comentario,CURRENT_TIMESTAMP(),:idUsuario,:idpost,:idComentarioPadre)";
        $consulta = $this->conn->prepare($sql);
        $consulta->bindParam(":idpost", $idPost);
        $consulta->bindParam(":idComentarioPadre", $idComentario);
        $consulta->bindParam(":comentario", $comentario);
        $consulta->bindParam(":idUsuario", $idUsuario);
        return $consulta->execute();
    }
    public function getSubComentario($idPost,$idComentario, $comentario, $idUsuario)
    {
        try {

            $sql = "SELECT o.*,u.nombre FROM comentarios o
    JOIN usuarios u ON u.id_usuario=o.id_usuario
     WHERE id_comentario_padre = :idComentarioPadre 
     AND id_post=:idpost
     AND contenido = :comentario 
     AND o.id_usuario = :idUsuario";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(":idpost", $idPost);
            $consulta->bindParam(":idComentarioPadre", $idComentario);
            $consulta->bindParam(":comentario", $comentario);
            $consulta->bindParam(":idUsuario", $idUsuario);
            $consulta->execute();
            $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);
            if ($resultado) {
                return $resultado;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
}
