<?php

namespace admin\foro\Helpers;


class VideoUploader
{
    private $tamanioMaximo; // Tamaño máximo permitido
    private $rutaDestino; // Ruta donde se guardarán los videos
    private $extensionesPermitidas; // Extensiones de video permitidas

    public function __construct($tamanioMaximo = 20 * 1024 * 1024) // 50 MB por defecto
    {
        $this->rutaDestino = "C:/xampp2/htdocs/proyectos/TFG/assets/videos/"; // Asegúrate de que la ruta termine con una barra
        $this->tamanioMaximo = $tamanioMaximo;
        $this->extensionesPermitidas = ['mp4', 'avi', 'mov', 'wmv', 'flv']; // Extensiones permitidas
    }

    public function subirVideo($video)
    {
        // Verifica si se ha subido un archivo
        if (isset($video) && $video['error'] == 0) {
            if ($video['size'] > $this->tamanioMaximo) {//tamaño
                return 'El archivo es demasiado grande.';
            }

            // Obtén la extensión del archivo
            $extension = pathinfo($video['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $this->extensionesPermitidas)) {//verifica extension
                return 'Extensión de archivo no permitida.';
            }

            $nombreVideo = uniqid() . '.' . $extension;//nombre nuevo video
            $rutaDestino = $this->rutaDestino . $nombreVideo;

            // Mueve el archivo a la ruta de destino
            if (move_uploaded_file($video['tmp_name'], $rutaDestino)) {
                return $nombreVideo; // Devuelve el nombre del video
            } else {
                // Manejo de errores si no se pudo mover el archivo
                return 'Error al mover el archivo.';
            }
        }
        return 'No se subió ningún archivo.'; // Si no se subió ningún archivo
    }
}