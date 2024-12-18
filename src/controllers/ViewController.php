<?php

namespace admin\foro\Controllers;

use admin\foro\Controllers\ErrorController;
use admin\foro\Helpers\Authentication;
use admin\foro\Models\ComunidadesModel;
use admin\foro\Models\ComunidadModel;
use admin\foro\Models\MembresiaModel;
use admin\foro\Models\MembresiasModel;
use admin\foro\Models\TemaModel;
use admin\foro\Models\TemasModel;
use admin\foro\Models\UsuarioModel;

class ViewController
{

    public static function show($viewName, $data = null)
    {
        try {
            self::showHeader();
            self::showSidebar1();
            self::showSidebar2();
            require_once $viewName;
            self::showFooter();
        } catch (\Exception $e) {
            echo "Error al cargar la vista: " . $e->getMessage();
            exit;
        }
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
        $comunidades = NULL;
        if (Authentication::isUserLogged()) {
            $idUsuario = $_SESSION['user']['idUsuario'];
            $comunidadesModel = new ComunidadModel();
            $usuariosModel = new UsuarioModel();
            $comunidades = $comunidadesModel->getComunidadesUnido($idUsuario);
        }
        include 'views/layout/sidebar1.php';
    }
    private static function showSidebar2()
    {
        $comunidadesModel = new ComunidadModel();
        $usuariosModel = new UsuarioModel();
        if(isset($_SESSION['user'])){
            $comunidades = $comunidadesModel->getComunidadesPopulares();
            if (isset($_SESSION['usuarioVer'])) {
                $usuario = $_SESSION['usuarioVer'];
                $datosUsuario = $usuariosModel->datosUsuario($usuario['id_usuario']);
            }
            if (isset($_SESSION['comunidadVer'])) {
                $comunidad = $_SESSION['comunidadVer'];
                $idUsuario = $_SESSION['user']['idUsuario'];
                $datosComunidad = $comunidadesModel->datosComunidad($comunidad, $idUsuario);
            }
        }else{
            $comunidades=$comunidadesModel->getComunidades();
        }
        if(isset($_SESSION['post'])){
            $post = $_SESSION['post'];
            /*echo "esoyt aqui";
            var_dump($post);exit;*/
        }
        include 'views/layout/sidebar2.php';
    }
    private static function showFooter()
    {
        include 'views/layout/footer.php';
    }
}
