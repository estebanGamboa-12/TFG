<?php

namespace admin\foro\Controllers;

use admin\foro\Helpers\Authentication;
use admin\foro\Models\VotoModel;

class VotosController
{

    public function votar()
    {
        if (Authentication::isUserLogged()) {
            header('Content-Type: application/json');
            $votosModel = new VotoModel();
            // Obtener los datos enviados en el body (en formato JSON)
            $data = json_decode(file_get_contents('php://input'), true);
            $idUsuario = $data['idUsuario'];
            $idPost = $data['idPost'];
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
        } else {
            ViewController::showError(403);
        }
    }
}
