<?php

namespace admin\foro\Models;

class VotoModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->tabla = "votos";
    }
    public function comprobarVoto($idUsuario, $idPost)
    {
        try {
            $sql = "SELECT * 
        FROM {$this->tabla} 
        WHERE id_usuario=:idUsuario AND id_post=:idPost";
            $sentencia = $this->conn->prepare($sql);
            $sentencia->bindParam(":idUsuario", $idUsuario, \PDO::PARAM_INT);
            $sentencia->bindParam(":idPost", $idPost, \PDO::PARAM_INT);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
        }
    }
    public function votarPost($idUsuario, $idPost)
    {
        try {
            $sql = "INSERT INTO {$this->tabla} (id_usuario, id_post, fecha_voto) 
        VALUES (:idUsuario, :idPost, CURRENT_TIMESTAMP)";
            $sentencia = $this->conn->prepare($sql);
            $sentencia->bindParam(":idUsuario", $idUsuario, \PDO::PARAM_INT);
            $sentencia->bindParam(":idPost", $idPost, \PDO::PARAM_INT);
            return $sentencia->execute();
        } catch (\PDOException $e) {
        }
    }
    public function numeroVotos($idPost)
    {
        try {
            $sql = "SELECT COUNT(*) AS votos 
        FROM {$this->tabla} 
        WHERE id_post=:idPost";
            $sentencia = $this->conn->prepare($sql);
            $sentencia->bindParam(":idPost", $idPost, \PDO::PARAM_INT);
            $sentencia->execute();
            $resultado = $sentencia->fetch(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\Exception $e) {
            //throw $th;
        }
    }
}
