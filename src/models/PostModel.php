<?php
namespace admin\foro\Models;

class PostModel extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->tabla="post";
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
    public function getPostPopular()
    {
        //1º consulta: saca todos los post
        //2º nombre imagen de cada comunidad y saber cuantos miembros tiene cada comunidad.
        //3º sacar todos los nombres de los temas.

        $sql1 = "SELECT u.nombre,u.imagen_logo_usuario,p.titulo,p.fecha_creacion,p.contenido,p.imagen,p.video ,p.tipo_post
         FROM post p
          JOIN usuarios u ON p.id_usuario=u.id; ";

        $sql2 = "SELECT c.nombre AS comunidad_nombre, c.imagen AS comunidad_imagen, COUNT(m.id_usuario) AS total_miembros 
        FROM comunidades c 
        LEFT JOIN membresias m ON c.id = m.id_comunidad 
        GROUP BY c.id, c.nombre, c.imagen;";
        $sql3 = "SELECT t.nombre AS nombre_tema 
        FROM temas t; ";
        try {
            //consulta1
            $consulta1 = $this->conn->prepare($sql1);
            $consulta1->execute();

            $dato = $consulta1->fetchAll(\PDO::FETCH_ASSOC);
            return $dato;
            exit;
                
            
            //consulta 2
            // $consulta2 = $this->conn->prepare($sql2);
            // $consulta2->execute();

            // while ($dato = $consulta2->fetch(\PDO::FETCH_ASSOC)) {
            //     $this->comunidades[] = $dato;
            // }
            // consulta3
            // $consulta3 = $this->conn->prepare($sql3);
            // $consulta3->execute();

            // while ($dato = $consulta3->fetch(\PDO::FETCH_ASSOC)) {
            //     $this->temas[] = $dato;
            // }
            $datos = [
                'post' => $dato,
                // 'comunidades' => $this->comunidades,
                // 'temas' => $this->temas
            ];
            //Retornar todos los datos.
            /* var_dump($datos);
            exit;*/
            return $datos;
        } catch (\PDOException $e) {
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" . $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function subirPost()
    {


        // Valores ficticios
        $titulo = "Título del Post Ejemplo";
        $contenido = "Este es el contenido del post. Aquí puedes hablar sobre cualquier tema que desees.";
        $id_usuario = 1; // Supongamos que el ID del usuario es 1
        $id_tema = 2; // Supongamos que el ID del tema es 2
        $tipo_post = "normal"; // Tipo de post, puede ser "publicación", "noticia", etc.

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
