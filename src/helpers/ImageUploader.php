<?php

namespace admin\foro\Helpers;

use admin\foro\Config\Parameters;

class ImageUploader
{
    private $tamanioMaximo; // Tamaño máximo permitido
    private $rutaDestino; // Ruta donde se guardarán las imágenes

    public function __construct($tamanioMaximo = 2 * 1024 * 1024) // 2 MB por defecto
    {
        $this->rutaDestino = "C:/xampp2/htdocs/proyectos/TFG/assets/img/"; // Asegúrate de que la ruta termine con una barra
        $this->tamanioMaximo = $tamanioMaximo;
    }

    public function subirImagen($imagen)
    {
        // Verifica si se ha subido un archivo
        if (isset($imagen) && $imagen['error'] == 0) {
            // Obtén la extensión del archivo
            $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            // Genera un nombre único para la imagen
            $nombreImagen = uniqid() . '.' . $extension;
            // Define la ruta donde se guardará la imagen
            $rutaDestino = $this->rutaDestino . $nombreImagen;

            // Mueve el archivo a la ruta de destino
            if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                return $nombreImagen; // Devuelve el nombre de la imagen
            } else {
                // Manejo de errores si no se pudo mover el archivo
                return null;
            }
        }
        return null; // Si no se subió ningún archivo
    }
}
