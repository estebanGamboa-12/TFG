<?php
namespace admin\foro\Helpers;

use admin\foro\Config\Parameters;

class Validations {
    public static function validateName($nombre): bool {
        return (!empty($nombre) && preg_match("/^[a-zñáéíóú]+([ ][a-zñáéíóú]+)*$/", strtolower($nombre)));
    }

    public static function validateFormatPassword($password): bool {
        if (empty($password)) {
            return false;
        }

        if (strlen($password) < Parameters::$PASSWORD_MIN_LENGTH) {
            return false;
        }

        return true;
    }

    public static function validateActivityName($nombreActividad): bool {
        return !empty($nombreActividad);
    }

    public static function validateActivityDate($fechaInicio): bool {
        return !empty($fechaInicio) && $fechaInicio >= date("Y-m-d");
    }
}
