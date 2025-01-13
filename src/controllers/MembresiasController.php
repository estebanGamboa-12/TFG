<?php

namespace admin\foro\Controllers;

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;
use admin\foro\Models\ComunidadModel;
use admin\foro\Models\MembresiaModel;
use admin\foro\Models\VotoModel;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class MembresiasController
{

    public function unirseComunidad()
    {
        if (Authentication::isUserLogged()) {
            header('Content-Type: application/json');
            $votosModel = new VotoModel();
            $membresiasModel = new MembresiaModel();
            // Obtener los datos enviados en el body (en formato JSON)
            $data = json_decode(file_get_contents('php://input'), true);
            $token = $data['token'];
            $key = $_SESSION['key'];  
            $alg = $_SESSION['alg']; 
            try {
                $decoded=JWT::decode($token, new Key($key,$alg));
                $idUsuario=$decoded->id_usuario;
                $idComunidad=$decoded->id_comunidad;
                $idPost=$decoded->id_post;
                
            $comprobarMembresia = $membresiasModel->comprobarSiEstaUnido($idUsuario, $idComunidad);
            if (count($comprobarMembresia) == 1) {
                echo json_encode(['success' => false, 'message' => 'No puedes unirte a una comunidad que ya estás unido']);
            } else {
                $comprobar = $membresiasModel->unirseComunidad($idUsuario, $idComunidad);
                $votosActuales=$votosModel->numeroVotos($idPost);
                if ($comprobar) {
                    $miembrosActuales = $membresiasModel->getNumeroMiembros($idComunidad);
                    echo json_encode([
                        'success' => true,
                        'message' => 'Te has unido a la comunidad ',
                        'miembros' => $miembrosActuales,
                        'votos' => $votosActuales['votos'],
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se ha podido realizar la operación']);
                }
            }
        } catch (Exception $e) {
            echo  json_encode( ['success' => false, "message"=>"Ocurrio un error inesperado intentelo mas tarde."]) ;
        }
        } else {
            ViewController::showError(403);
        }
    }
    public function dejarSeguir(){
        if (Authentication::isUserLogged()) {
            $idComunidad=intval($_GET['idComunidad']);
            $idUsuario=$_SESSION['user']['idUsuario'];
            $membresiasModel = new MembresiaModel();
            $comprobar=$membresiasModel->dejarDeSeguirComunidad($idUsuario,$idComunidad);
            if ($comprobar) {
                header("location:". Parameters::$BASE_URL."Comunidades/explorar");
                exit;
            }else{
                ViewController::showError(403);
            }
        }
    }
}
