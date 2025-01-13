<?php

namespace admin\foro\Helpers;

use admin\foro\Config\Parameters;

class ImageUploader
{
    private $tamanioMaximo; // Tamaño máximo permitido
    private $rutaDestino; // Ruta donde se guardarán las imágenes
    private $extensionesPermitidas; // Extensiones de imagen permitidas

    public function __construct($tamanioMaximo = 5 * 1024 * 1024) // 2 MB por defecto
    {
        $this->rutaDestino = "C:/xampp/htdocs/TFG/assets/img/"; // Asegúrate de que la ruta termine con una barra
        $this->tamanioMaximo = $tamanioMaximo;
        $this->extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'bmp']; // Extensiones permitidas
    }

    public function subirImagen($imagen)
    {
        // Verifica si se ha subido un archivo
        if (isset($imagen) && $imagen['error'] == 0) {
            // Verifica el tamaño del archivo
            if ($imagen['size'] > $this->tamanioMaximo) {
                return 'El archivo es demasiado grande. El tamaño máximo permitido es ' . ($this->tamanioMaximo / (1024 * 1024)) . ' MB.';
            }

            // Obtén la extensión del archivo
            $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            // Verifica si la extensión es permitida
            if (!in_array(strtolower($extension), $this->extensionesPermitidas)) {
                return 'Extensión de archivo no permitida. Las extensiones permitidas son: ' . implode(', ', $this->extensionesPermitidas) . '.';
            }

            // Genera un nombre único para la imagen
            $nombreImagen = uniqid() . '.' . $extension;
            // Define la ruta donde se guardará la imagen
            $rutaDestino = $this->rutaDestino . $nombreImagen;

            // Mueve el archivo a la ruta de destino
            if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                return $nombreImagen; // Devuelve el nombre de la imagen
            } else {
                // Manejo de errores si no se pudo mover el archivo
                return 'Error al mover el archivo.';
            }
        }
        return 'No se subió ningún archivo.'; // Si no se subió ningún archivo
    }
}