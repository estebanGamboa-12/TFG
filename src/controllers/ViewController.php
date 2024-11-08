<?php
namespace admin\foro\Controllers;
use admin\foro\Controllers\ErrorController;
use admin\foro\Models\ComunidadesModel;

class ViewController{

    public static function show($viewName, $data = null){
        self::showHeader();
        self::showSidebar1();
        self::showSidebar2();
        require_once $viewName;
        self::showFooter();
    }
    
    public static function showError($error){
        self::showHeader();
        self::showSidebar1();
        $metodoError = "show".$error;
        (new ErrorController())->$metodoError();
        self::showFooter();
    }

    private static function showHeader(){
        include 'views/layout/header.php';        
    }
    private static function showSidebar1(){
        //$temasModel=new TemasModel();
        include 'views/layout/sidebar1.php';
    }
    private static function showSidebar2(){

        $comunidadesModel=new ComunidadesModel();
        $comunidades=$comunidadesModel->getAll();
        var_dump($comunidades);
        exit;
        include 'views/layout/sidebar2.php';
    }
    private static function showFooter(){
        include 'views/layout/footer.php';            
    }

}
