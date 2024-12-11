<?php
require_once 'vendor/autoload.php';

session_start();

use admin\foro\Config\Parameters;
use admin\foro\Controllers\ViewController;

// CONTROLADOR FRONTAL:
$nameController = "admin\\foro\Controllers\\";

// Obtener el controlador desde el parámetro GET o usar la función para obtener valores por defecto
$controllerName = $_GET['controller'] ?? null;
$action = $_GET['action'] ?? null;

// Si no se proporciona el controlador o la acción, usar los valores por defecto
if (is_null($controllerName) || is_null($action)) {
    $controllerAndAction = Parameters::getControllerAndAction();
    $controllerName = $controllerAndAction['controller'];
    $action = $controllerAndAction['action'];
}

// Construir el nombre completo del controlador
$nameController .= ucfirst(strtolower($controllerName)) . "Controller"; // Capitaliza el controlador

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