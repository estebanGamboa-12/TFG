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
    }

?>