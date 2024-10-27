<?php

spl_autoload_register(function ($clase) {
    $pathController = 'app/controladores/' . $clase . '.php';
    $pathModels = 'app/modelos/' . $clase . '.php';
    $pathConfigs = 'config/' . $clase . '.php';
    if (file_exists($pathController)) {
        require_once  $pathController;
    } elseif (file_exists($pathModels)) {
        require_once $pathModels;
    } elseif (file_exists($pathConfigs)) {
        require_once $pathConfigs;
    }
});
//Iniciamos sesion sin datos
!isset($_SESSION['nombre']) ? session_start():NULL;
$map=array(
    'home'=>array(
        'controller'=>'ControllerPost',
        'action'=> 'mostrarPostPopulares',
    ),
    'iniciarSesion'=>array(
        'controller'=>'ControllerUsuario',
        'action'=> 'iniciarSesion',
    ),
    'registrar'=>array(
        'controller'=>'ControllerUsuario',
        'action'=> 'registrarUsuarios',
    ),
);

if (isset($_REQUEST['ctl'])) {
    if (isset($map[$_REQUEST['ctl']])) {
        $ruta = $_REQUEST['ctl'];
    } else {
        header('Status: 404 Not Found'); // Cambiar a comillas simples
        echo '<p><h1>Error 404: No existe la ruta <i>' . $_REQUEST['ctl'] . '</h1></p>';
        exit;
    }
} else {
    $ruta = 'home';
}
$controlador= $map[$ruta];
// echo '<pre>';
// var_dump($controlador);    
// exit;
//Ejecucion del controlador asociado a la ruta

if (method_exists($controlador['controller'], $controlador['action'])) {
    call_user_func(
        array(
            new $controlador['controller'],
            $controlador['action']
        )
    );
} else {

    header('Status: 404 Not Found');
    echo '<p><h1>Error 404: El controlador <i>' . $controlador['controller'] . '->' . $controlador['action'] .
        '</i> no existe</h1></p>';
}