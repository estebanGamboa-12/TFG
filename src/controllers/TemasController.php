<?php

namespace admin\foro\Controllers;

use admin\foro\Models\ComunidadModel;
use admin\foro\Models\TemaModel;
use admin\foro\Models\temasComunidadModel;
use admin\foro\Models\TemasModel;

class TemasController
{

    public function mostrarTemas() // inicio y la parte populares logeado es la misma
    {
        $temasModel = new TemaModel();
        $temas = $temasModel->getTemas();
    }
    public function mostrarForm() // 
    {
        require "app/vistas/crearPost.php";
        exit;
    }
    public function obtenerTemas()
    {
        $temasModel = new TemaModel();
        $temasComunidadModel = new temasComunidadModel();
        $temas = [];
        $idComunidad = intval($_GET['idComunidad']);
        $idTemas = $temasComunidadModel->getTemasPorComunidad($idComunidad);
        foreach ($idTemas as $tema) {
            $temasModel = new TemaModel();
            $temaObtenido = $temasModel->getTemasPorId($tema['id_tema']);
            if (!empty($temaObtenido)) {
                $temas[] = $temaObtenido[0]; 
            }
        }
        if ($temas) {
            echo json_encode(["success" => true, "temas" => $temas]);
        } else {
            echo json_encode(["success" => false]);
        }
    }
    public function verTemas(){ 
        $temasComunidadModel = new temasComunidadModel();
        $temasModel= new TemaModel();
        $comuninidadesModel=new ComunidadModel();
        $nombreTema=$_GET['nombreTema'];
        $temas=$temasModel->getTemaPorNombre($nombreTema);
        if(empty($temas)){
            echo "no hay nah bro";
            exit;
        }else{
            $idTema=$temas['id_temas'];
            $comunidades=$temasComunidadModel->getComunidadesPorTema($idTema);
            var_dump($comunidades);exit;
            $comunidades=$comuninidadesModel->comunidadesPorNombre();
        }

    }
}
