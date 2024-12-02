<?php 

namespace admin\foro\Controllers;

use admin\foro\Helpers\Authentication;
use admin\foro\Models\ComunidadesModel;
use admin\foro\Models\ComunidadModel;
use admin\foro\Models\MembresiaModel;
use Firebase\JWT\JWT;

class ComunidadesController{

    public function explorar(){
        if(Authentication::isUserLogged()){

            $comunidadesModel=new ComunidadModel();
            $membresiasModel=new MembresiaModel();
            $comunidades= $comunidadesModel->getComunidades();
            $membresias=[];
            $token=[];
            $idUsuario=$_SESSION['user']['idUsuario'];

            foreach($comunidades as  $indice=>$contenido){
                $membresiasComunidad=$membresiasModel->getNumeroMiembros($contenido['id_comunidad']);
                $membresias[$contenido['id_comunidad']]=$membresiasComunidad;
                $token[$contenido['id_comunidad']]=self::generarToken($idUsuario,$contenido['id_comunidad'],NULL);
            }
            
            ViewController::show("views/comunidades/explorarComunidades.php",[
            'comunidades'=>$comunidades,
            "membresias"=>$membresias,
            "tokens"=>$token]);
        }else{
            ViewController::showError(403);
        }
        }
        
    public function verComunidad(){
        if(Authentication::isUserLogged()){
            $comunidadesModel=new ComunidadModel();
            
            $_SESSION['comunidadesRecientes']['nombre']=$_GET['idComunidad'];
            $comunidades=$comunidadesModel->comunidadesPorNombre($_GET['idComunidad']);
            var_dump($comunidades);exit;
            ViewController::show( "views/comunidades/verComunidad.php");
        }else{
            ViewController::showError(403);
        }
    }
    public static function generarToken($idUsuario, $idComunidad, $idpost)
    {
        $token_data = array(
            "id_usuario" => $idUsuario,
            "id_comunidad" => $idComunidad,
            "id_post" => $idpost,
        );
        $key = "123"; //clave secreta
        $alg = 'HS256';
        $_SESSION['key'] = $key;
        $_SESSION['alg'] = $alg;
        $jwt = JWT::encode($token_data, $key, $alg);
        return $jwt;
        // Generar el token JWT
    }
}
    

?>