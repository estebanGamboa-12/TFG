<?php

namespace admin\foro\Controllers;

use admin\foro\Models\ComentariosModel;
use admin\foro\Models\PostModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ComentariosController
{
    public function verVistaComentarios()
    {
        $rowdata = file_get_contents('php://input');
        $data = json_decode($rowdata, true);
        $token = $data['token'];
        $key = $_SESSION['key'];
        $alg = $_SESSION['alg'];
        try {
            $decoded = JWT::decode($token, new Key($key, $alg));
            $idUsuario = $decoded->id_usuario;
            $idComunidad = $decoded->id_comunidad;
            $idPost = $decoded->id_post;
            $postModel = new PostModel();
            $posts = $postModel->postPorId($idPost);
            echo json_encode(["success" => true, "post" => $posts]);
        } catch (\PDOException $e) {
            echo json_encode(["success" => false, "mensaje" => "Hubo un error inesperado.Intene más tarde"]);
        }
    }
   public function subirComentario()
    {
        $rowdata = file_get_contents('php://input');
        $data = json_decode($rowdata, true);
        $comentario = $data['comentario'];
        $idPost = isset($data['idPost']) ? intval($data['idPost']) : null; // Para comentarios principales
        $idComentario = isset($data['idComentario']) ? intval($data['idComentario']) : null; // Para subcomentarios
        $idUsuario = $_SESSION['user']['idUsuario'];
        if (empty($comentario)) {
            echo json_encode(["success" => false, "mensaje" => "No puede subir un comentario vacio"]);
            exit;
        }

        $comentariosModel = new ComentariosModel();
        // Determinar si es un comentario principal o un subcomentario
        if ($idPost !== null && $idComentario === null) {
            // Es un comentario principal
            $comprobar = $comentariosModel->subirComentario($idPost, $comentario, $idUsuario);
        } elseif ($idPost !== null && $idComentario !== null) {
            // Es un subcomentario
            $comprobar = $comentariosModel->subirSubComentario($idPost,$idComentario, $comentario, $idUsuario);
        } else {
            echo json_encode(["success" => false, "mensaje" => "Faltan datos para procesar el comentario"]);
            exit;
        }

        if ($comprobar) {
            // Obtener el último comentario o subcomentario agregado
            $ultimoComentario = $idComentario === null
                ? $comentariosModel->getComentario($idPost, $comentario, $idUsuario)
                : $comentariosModel->getSubComentario($idPost,$idComentario, $comentario, $idUsuario);

            echo json_encode(
                [
                    "success" => true,
                    "mensaje" => "Comentario agregado con éxito",
                    "comentario" => $ultimoComentario,
                ]
            );
        } else {
            echo json_encode(
                [
                    "success" => false,
                    "mensaje" => "Hubo un error al agregar el comentario"
                ]
            );
        }
    }
}
