<?php
namespace admin\foro\Config;

use admin\foro\Helpers\Authentication;

class Parameters {
    public static $CONTROLLER_DEFAULT = "Post";
    public static $ACTION_DEFAULT = "popularNoLogeado";

    public static $PASSWORD_MIN_LENGTH = 6;
    
    public static $BASE_URL = "http://192.168.3.210/proyectos/TFG/";

    public static function getControllerAndAction() {
        if (Authentication::isUserLogged()) {
            return [
                'controller' => 'Post',
                'action' => 'home'
            ];
        } else {
            return [
                'controller' => self::$CONTROLLER_DEFAULT,
                'action' => self::$ACTION_DEFAULT
            ];
        }
    }
}