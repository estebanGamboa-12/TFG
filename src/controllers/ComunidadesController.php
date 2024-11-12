<?php 

namespace admin\foro\Controllers;

use admin\foro\Models\ComunidadesModel;
use admin\foro\Models\ComunidadModel;
use admin\foro\Models\MembresiaModel;

class ComunidadesController{

    public function explorar(){
        $comunidadesModel=new ComunidadModel();
        $membresiasModel=new MembresiaModel();
        $comunidades= $comunidadesModel->getComunidades();
        $membresias=[];
        foreach($comunidades as  $indice=>$contenido){
            $membresiasComunidad=$membresiasModel->getNumeroMiembros($contenido['id']);
            $membresias[$contenido['id']]=$membresiasComunidad;
        }

        ViewController::show("views/comunidades/explorarComunidades.php",['comunidades'=>$comunidades,"membresias"=>$membresias]);
    }
    public function home(){
        $comunidadesModel=new ComunidadModel();
        $comunidades= $comunidadesModel->getComunidadesHome();

        //ViewController::show("views/comunidades/.php",['comunidades'=>$comunidades,"membresias"=>$membresias]);
    }
}

?>