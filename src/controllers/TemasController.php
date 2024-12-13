<?php

namespace admin\foro\Controllers;

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
        $idComunidad = $_GET['idComunidad'];
        $idTemas = $temasComunidadModel->getTemasPorComunidad($idComunidad);
        var_dump($idTemas);exit; 
        foreach ($idTemas['id_tema'] as $idTema) {
            $temasModel = new TemaModel();
            $temas = $temasModel->getTemasPorId($idTema);
        }
        if ($temas) {
            var_dump($temas);exit;
            echo json_encode(["success" => true, "temas" => $temas]);
        } else {
            echo json_encode(["success" => false]);
        }
    }
}
