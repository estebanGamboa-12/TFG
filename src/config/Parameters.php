<?php
namespace admin\foro\Config;

use admin\foro\Helpers\Authentication;

class Parameters {
    public static $CONTROLLER_DEFAULT = "Post";
    public static $ACTION_DEFAULT = "popularNoLogeado";

    public static $PASSWORD_MIN_LENGTH = 6;

    public static $BASE_URL = "http://localhost/proyectos/TFG/";

    public static function getControllerAndAction() {
        if (Authentication::isUserLogged()) {
            // Si el usuario está logueado, redirigir a otro controlador y acción
            return [
                'controller' => 'Post', // Cambia esto al controlador que desees
                'action' => 'home' // Cambia esto a la acción que desees
            ];
        } else {
            // Si el usuario no está logueado, usar los valores por defecto
            return [
                'controller' => self::$CONTROLLER_DEFAULT,
                'action' => self::$ACTION_DEFAULT
            ];
        }
    }
}