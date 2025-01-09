<?php

namespace admin\foro\Controllers;

use admin\foro\Helpers\Authentication;
use admin\foro\Models\VotoModel;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class VotosController
{

    public function votar()
    {
        if (Authentication::isUserLogged()) {
            header('Content-Type: application/json');
            $votosModel = new VotoModel();
            $data = json_decode(file_get_contents('php://input'), true);

            $token = $data['token']; 
            
            $key = $_SESSION['key']; 
            $alg = $_SESSION['alg'];  

            try {
                $decoded = JWT::decode($token, new Key($key, $alg));

                $idUsuario=$decoded->id_usuario;
                $idPost=$decoded->id_post;
             $comprobarVoto = $votosModel->comprobarVoto($idUsuario, $idPost);
            if (count($comprobarVoto) == 1) {
                echo json_encode(['success' => false, 'message' => 'No puedes votar a un post que ya has votado']);
            } else {
                $comprobar = $votosModel->votarPost($idUsuario, $idPost);
                $votosActuales=$votosModel->numeroVotos($idPost);
                if ($comprobar) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Has votado ',
                        'votos' => $votosActuales['votos'],
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se ha podido realizar la operación']);
                }
            }
        } catch (Exception $e) {
            // Si hay un error en la decodificación, muestra el mensaje de error
            echo  json_encode( ['success' => false, "message"=>"Ocurrio un error inesperado intentelo mas tarde."]) ;
        }
        } else {
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
        }
    }
}
