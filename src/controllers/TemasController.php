<?php

namespace admin\foro\Controllers;

use admin\foro\Models\TemasModel;

class TemasController
{

    public function mostrarTemas() // inicio y la parte populares logeado es la misma
    {
        $temasModel = new TemasModel();

        $temas = $temasModel->getTemas();
        
    }
    public function mostrarForm() // 
    {
        require "app/vistas/crearPost.php";
        exit;
    }
}
