<?php
require_once 'vendor/autoload.php';

session_start();

use admin\foro\Config\Parameters;
use admin\foro\Controllers\ViewController;

// CONTROLADOR FRONTAL:
$nameController = "admin\\foro\Controllers\\";

// Obtener el controlador desde el parámetro GET o usar el valor por defecto
$controllerName = $_GET['controller'] ?? Parameters::$CONTROLLER_DEFAULT;
$nameController .= ucfirst(strtolower($controllerName)) . "Controller"; // Capitaliza el controlador

// Obtener la acción desde el parámetro GET o usar el valor por defecto
$action = $_GET['action'] ?? Parameters::$ACTION_DEFAULT;

// Verificar si la clase existe
if (class_exists($nameController)) {
    $controller = new $nameController();
    
    // Verificar si el método de acción existe en la clase
    if (method_exists($controller, $action)) {
        $controller->$action();  // Llamar al método de acción
    } else {
        // Si el método no existe, mostramos un error 404
        (new ViewController())->showError(404);
    }
} else {
    // Si la clase no existe, mostramos un error 404
    (new ViewController())->showError(404);
}
