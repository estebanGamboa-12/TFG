<?php 
namespace admin\foro\Models;


namespace admin\foro\Models;
use admin\foro\Database\Conexion;

class Model{
    protected $conn;
    protected $tabla;

    public function __construct(){
        $this->conn = Conexion::conectar();
    }

    public function getOne($id){
        try {

            $consulta = "select * from {$this->tabla} where idColaborador = :id";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':id', $id);
            //$sentencia->setFetchMode(\PDO::FETCH_ASSOC);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            
            $resultado = $sentencia->fetch();
            return $resultado;

        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            // Registrar en un sistema de Log
            return NULL;
        }
    }
    public function getAll(){
        $sql="SELECT * FROM {$this->tabla}";
        $consulta=$this->conn->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function cerrar_conexion()
    {
        $this->conn = NULL;
    }

}


?>
