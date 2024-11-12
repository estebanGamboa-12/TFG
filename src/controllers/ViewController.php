<?php

namespace admin\foro\Controllers;

use admin\foro\Controllers\ErrorController;
use admin\foro\Models\ComunidadesModel;
use admin\foro\Models\ComunidadModel;
use admin\foro\Models\MembresiaModel;
use admin\foro\Models\MembresiasModel;
use admin\foro\Models\TemaModel;
use admin\foro\Models\TemasModel;

class ViewController
{

    public static function show($viewName, $data = null)
    {
        self::showHeader();
        self::showSidebar1();
        self::showSidebar2();
        require_once $viewName;
        self::showFooter();
    }

    public static function showError($error)
    {
        self::showHeader();
        self::showSidebar1();
        $metodoError = "show" . $error;
        (new ErrorController())->$metodoError();
        self::showFooter();
    }

    private static function showHeader()
    {
        include 'views/layout/header.php';
    }
    private static function showSidebar1()
    {
        $temasModel = new TemaModel();
        $temas = $temasModel->getTemas();
        include 'views/layout/sidebar1.php';
    }
    private static function showSidebar2()
    {
        $comunidadesModel = new ComunidadModel();
        $comunidades = $comunidadesModel->getComunidades();

        $membresias = [];  

        $membresiasModel = new MembresiaModel();
        foreach ($comunidades as $indice => $contenido) {
            $membresiasComunidad = $membresiasModel->getNumeroMiembros($contenido['id']);
            // Guardamos el resultado en el array $membresias
            $membresias[$contenido['id']] = $membresiasComunidad; // Usamos el id de la comunidad como clave
        }

        include 'views/layout/sidebar2.php';
    }
    private static function showFooter()
    {
        include 'views/layout/footer.php';
    }
}
