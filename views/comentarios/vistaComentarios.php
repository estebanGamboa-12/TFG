<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

$post = $data['post'] ?? NULL;
$comentarios = $data['comentarios'] ?? NULL;
$token = $data['token'] ?? NULL;


$idUsuario = $_SESSION['user']['idUsuario'] ?? NULL;
?>
<pre>
    <?php
    //var_dump($comentarios);
    ?>
</pre>
<style>
    #card-comentarios {
        display: flex;
        flex-direction: column;
        margin: 20px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
    }

    .conteinerEncabezado-comentarios {
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-bottom: 20px;
    }

    .flecha-comentarios,
    .imagen-comentarios img {
        height: 2rem;
        width: 2rem;
        border-radius: 1rem;
    }

    .nombre-comentarios,
    .fecha-comentarios {
        margin-left: 10px;
    }

    .titulo-post-comentarios {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .imagen-post-comentarios img {
        width: 100%;
        height: auto;
        margin-top: 2%;
        margin-bottom: 2%;
        border-radius: 10px;
    }

    .containerBotones-comentarios {
        display: flex;
        flex-direction: row;
        margin-bottom: 10px;
    }

    .boton {
        background-color: #009688;
        padding: 5px 10px;
        border-radius: 1rem;
        margin-right: 10px;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .inputComentar input {
        width: 100%;
        border-radius: 1rem;
        margin: 2% 0%;
        height: 2rem;
        padding: 0 10px;
    }

    .card-caja-comentarios {
        display: flex;
        flex-direction: column;
    }

    .comentario {
        margin: 20px 0;
        padding: 10px;
        background-color: #f1f1f1;
        border-radius: 10px;
    }

    .containerComentarios {
        display: flex;
        align-items: center;
    }

    .comentario-sub {
        margin: 10px 0;
        padding: 10px;
        border-radius: 10px;
        margin-left: 20px;
    }

    .subcomentarios {
        margin-top: 15px;
    }

    .contenido-comentario {
        margin: 10px 0;
    }


    .comentar-comentarios {
        margin-left: 20px;
    }

    .boton-enviar-comentario {
        border-radius: 1rem;
        padding: 5px 10px;
        display: flex;
        background-color: #00796b;
        width: 5rem;
        margin-left: auto;
        cursor: pointer;
    }
</style>
<section id="section">
    <div class="sectionAll">
        <div class="card-section" id="card-comentarios">
            <!-- Título y contenido del post -->
            <div class="conteinerEncabezado-comentarios">
                <div class="flecha-comentarios">
                    <i class="material-icons">arrow_back</i>
                </div>
                <div class="imagen-comentarios">
                    <img src="<?= Parameters::$BASE_URL ?>assets/img/1.jpg" alt="Usuario">
                </div>
                <div class="nombre-comentarios"><?= $post['nombre'] ?></div>
                <div class="fecha-comentarios"><?= $post['fecha_creacion'] ?></div>
            </div>
            <h2 class="titulo-post-comentarios"><?= $post['titulo'] ?></h2>
            <div class="nombre-comentarios"><?= $post['contenido'] ?></div>
            <div class="imagen-post-comentarios">
                <img src="<?= Parameters::$BASE_URL ?>assets/img/1.jpg" alt="imagen">
            </div>
            <div class="containerBotones-comentarios">
                <div class="votar-comentarios boton">Votos (<?= $post['votos_totales'] ?>)</div>
                <div class="comentar-comentarios boton">Comentar</div>
                <div class="compartir-comentarios boton">Compartir</div>
            </div>
            <div class="inputComentar">
                <input type="texto" placeholder="Comentar">
                <span class="boton-enviar-comentario">Comentar</span>
            </div>
            <!-- Lista de comentarios -->
            <div class="card-caja-comentarios">
                <?php
                // Comprobamos si hay comentarios disponibles
                if (isset($comentarios) && count($comentarios) > 0) {
                    foreach ($comentarios as $comentario) {
                        foreach($comentario as $contenido){
                            var_dump($contenido);
                            // Mostrar el comentario principal
                            echo '<div class="comentario">';
                            echo '<div class="containerComentarios">';
                            echo '<div class="imagen-comentarios">';
                            echo '<img src="' . Parameters::$BASE_URL . 'assets/img/1.jpg" alt="Usuario">';
                            echo '</div>';
                            echo '<div class="nombre-comentarios">' . htmlspecialchars($contenido['nombre_usuario_comentario']) . '</div>';
                            echo '<div class="fecha-comentarios">' . $contenido['fecha_creacion'] . '</div>';
                            echo '</div>';
                            echo '<div class="contenido-comentario">' . htmlspecialchars($contenido['contenido']) . '</div>';
                            echo '<div class="containerBotones-comentarios">';
                            echo '<div class="votar-comentarios boton">Votar</div>';
                            echo '<div class="comentar-comentarios boton">Comentar</div>';
                            echo '</div>';
                            
                            // Mostrar subcomentarios si existen
                            mostrarSubcomentarios($contenido['id_comentario'], $subcomentarios);
                            echo '</div>'; // Cerrar comentario principal
                        }
                    }
                } else {
                    echo '<p>No hay comentarios disponibles para este post.</p>';
                }

                /**
                 * Función recursiva para mostrar subcomentarios
                 */
                function mostrarSubcomentarios($idComentarioPadre, $subcomentarios)
                {
                    // Filtramos los subcomentarios que corresponden a este comentario padre
                    $subcomentariosFiltrados = array_filter($subcomentarios, function ($subcomentario) use ($idComentarioPadre) {
                        return $subcomentario['subcomentario_padre'] == $idComentarioPadre;
                    });

                    // Si hay subcomentarios, los mostramos
                    if (count($subcomentariosFiltrados) > 0) {
                        echo '<div class="subcomentarios">';
                        foreach ($subcomentariosFiltrados as $subcomentario) {
                            echo '<div class="comentario-sub">';
                            echo '<div class="containerComentarios">';
                            echo '<div class="imagen-comentarios">';
                            echo '<img src="' . Parameters::$BASE_URL . 'assets/img/1.jpg" alt="Usuario">';
                            echo '</div>';
                            echo '<div class="nombre-comentarios">' . htmlspecialchars($subcomentario['nombre_usuario_subcomentario']) . '</div>';
                            echo '<div class="fecha-comentarios">' . $subcomentario['subcomentario_fecha'] . '</div>';
                            echo '</div>';
                            echo '<div class="contenido-comentario">' . htmlspecialchars($subcomentario['subcomentario_contenido']) . '</div>';
                            echo '<div class="containerBotones-comentarios">';
                            echo '<div class="votar-comentarios boton">Votar</div>';
                            echo '<div class="comentar-comentarios boton">Comentar</div>';
                            echo '</div>';

                            // Llamada recursiva para mostrar subsubcomentarios si los hay
                            mostrarSubcomentarios($subcomentario['subcomentario_id'], $subcomentarios);
                            echo '</div>'; // Cerrar subcomentario
                        }
                        echo '</div>'; // Cerrar subcomentarios
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>