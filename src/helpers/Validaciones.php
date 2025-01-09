<?php

namespace admin\foro\Helpers;

class Validaciones
{
    // Método para sanitizar el texto y evitar HTML
    public static function sanitizarTexto($texto)
    {
        // Eliminar etiquetas HTML y PHP
        $texto = strip_tags($texto);
        // Convertir caracteres especiales a entidades HTML
        $texto = htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
        return $texto;
    }

    // Método para capitalizar la primera letra de cada palabra
    public static function capitalizarTexto($texto)
    {
        return ucwords(strtolower($texto));
    }

    // Método para validar y sanitizar un campo de texto
    public static function validarCampo($texto)
    {
        $textoSanitizado = self::sanitizarTexto($texto);
        return self::capitalizarTexto($textoSanitizado);
    }
}
