<?php

namespace admin\foro\Controllers;

use admin\foro\Models\PostModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ComentariosController
{
    public function verVistaComentarios(){
        $rowdata=file_get_contents('php://input');
        $data=json_decode($rowdata,true);
        $token=$data['token'];
        $key = $_SESSION['key'];  
        $alg = $_SESSION['alg']; 
        try{
            $decoded=JWT::decode($token, new Key($key,$alg));
            $idUsuario=$decoded->id_usuario;
            $idComunidad=$decoded->id_comunidad;
            $idPost=$decoded->id_post;
            $postModel=new PostModel();
            $posts=$postModel->postPorId($idPost);
            var_dump($posts);
            //echo json_decode($posts);
        }catch(\PDOException $e){
            echo json_encode("Hubo un error inesperado.Intene más tarde");
        }
    }

}