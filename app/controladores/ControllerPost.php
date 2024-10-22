<?php
require '../modelos/Post.php';
class ControllerPost
{
    private $postModel;

    public function __construct()
    {
        $this->postModel = new Post(); // Asegúrate de que la clase Post esté definida correctamente
    }

    public function mostrarPostAleatorios()
    {
        header('Content-Type: application/json'); // Establece el tipo de contenido para JSON
        $posts = $this->postModel->obtenerPostAleatorios(); // Llama al método para obtener los posts
        
        if (empty($posts)) {
            echo json_encode([]); // Devuelve un array vacío si no hay posts
        } else {
            echo json_encode($posts); // Devuelve los posts en formato JSON
        }
    }
}
