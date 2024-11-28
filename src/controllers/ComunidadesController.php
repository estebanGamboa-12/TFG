<?php 

namespace admin\foro\Controllers;

use admin\foro\Helpers\Authentication;
use admin\foro\Models\ComunidadesModel;
use admin\foro\Models\ComunidadModel;
use admin\foro\Models\MembresiaModel;

class ComunidadesController{

    public function explorar(){
        if(Authentication::isUserLogged()){

            $comunidadesModel=new ComunidadModel();
            $membresiasModel=new MembresiaModel();
            $comunidades= $comunidadesModel->getComunidades();
            $membresias=[];
            foreach($comunidades as  $indice=>$contenido){
                $membresiasComunidad=$membresiasModel->getNumeroMiembros($contenido['id_comunidad']);
                $membresias[$contenido['id_comunidad']]=$membresiasComunidad;
            }
            
            ViewController::show("views/comunidades/explorarComunidades.php",['comunidades'=>$comunidades,"membresias"=>$membresias]);
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
}
    

?>