<?php

class Post
{
    private $conexion;
    private $posts;
    private $comunidades;
    private $temas;

    public function __construct()
    {
        $this->conexion = Conectar::conexion(); // Conecta a la base de datos
        $this->posts=array();
    }

    public function obtenerPostAleatorios()
    {//modificar la sql , de momento de prueba 
        $sql = "SELECT u.nombre,u.imagen,p.titulo,p.fecha_creacion,p.contenido,p.imagen,p.video ,p.tipo_post FROM post p JOIN usuarios u ON p.id_usuario=u.id;  "; 
        try{
            $consulta=$this->conexion->prepare($sql);
            $consulta->execute();
            
            while($dato=$consulta->fetch(PDO::FETCH_ASSOC)){
                $this->posts[]=$dato;
            }
            return $this->posts;

        }catch(PDOException $e){
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" .  $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function getPostPopular()
    {
        //1º consulta: saca todos los post
        //2º nombre imagen de cada comunidad y saber cuantos miembros tiene cada comunidad.
        //3º sacar todos los nombres de los temas.
        //4º
        $sql1 = "SELECT u.nombre,u.imagen_logo_usuario,p.titulo,p.fecha_creacion,p.contenido,p.imagen,p.video ,p.tipo_post
         FROM post p
          JOIN usuarios u ON p.id_usuario=u.id; "; 
          
        $sql2 = "SELECT c.nombre AS comunidad_nombre, c.imagen AS comunidad_imagen, COUNT(m.id_usuario) AS total_miembros 
        FROM comunidades c 
        LEFT JOIN membresias m ON c.id = m.id_comunidad 
        GROUP BY c.id, c.nombre, c.imagen;";
        $sql3="SELECT t.nombre AS nombre_tema 
        FROM temas t; ";
        try{
            //consulta1
            $consulta1=$this->conexion->prepare($sql1);
            $consulta1->execute();
            
            while($dato=$consulta1->fetch(PDO::FETCH_ASSOC)){
                $this->posts[]=$dato;
            }
            //consulta 2
            $consulta2=$this->conexion->prepare($sql2);
            $consulta2->execute();

            while($dato=$consulta2->fetch(PDO::FETCH_ASSOC)){
                $this->comunidades[]=$dato;
            }
            // consulta3
            $consulta3=$this->conexion->prepare($sql3);
            $consulta3->execute();

            while($dato=$consulta3->fetch(PDO::FETCH_ASSOC)){
                $this->temas[]=$dato;
            }
            $datos=[
                'post'=>$this->posts,
                'comunidades'=>$this->comunidades,
                'temas'=>$this->temas
            ];
            

            //Retornar todos los datos.
            return $datos;
            
            

        }catch(PDOException $e){
            echo "<h1><br>Fichero: " . $e->getFile();
            echo "<br>Linea:" .  $e->getLine() . "<br>Mensaje : ";
            die($e->getMessage());
        }
    }
    public function cerrar_conexion(){
        $this->conexion=NULL;
    }
}
?>