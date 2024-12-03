<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;
$post = $data['post'] ?? NULL;
$token = $data['token'] ?? NULL;


$idUsuario = $_SESSION['user']['idUsuario'] ?? NULL;
?>
<style>
    .votar {
        cursor: pointer;
    }

    /* Estilo para el contenedor del cargador */
    #loading {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 16px;
    }

    /* Animación de giro para el spinner */
    .spinner {
        border: 4px solid #f3f3f3;
        /* Gris claro */
        border-top: 4px solid #3498db;
        /* Azul */
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 2s linear infinite;
        margin-bottom: 10px;
    }

    /* Definición de la animación de giro */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<pre>
    <?php //var_dump($post);exit; 
    ?>
</pre>
<section id="sectionPopular">
    <div class="section">
        <div class="contenidoMensajes"></div>
        <?php foreach ($post as $indice => $contenido): ?>
            <div class="card-section">
                <div class="encabezado-section">
                    <?php if($contenido['tipo_post']==="normal"){?>
                        <a href="<?= Parameters::$BASE_URL?>Usuario/verUsuario?nombre=<?= $contenido['nombre']?>">
                        <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen_logo_usuario'] ?>" alt="imagen" class="imagenLogo-section">
                        </a>
                        <div class="nombre-section">
                            <?= "n/" . $contenido['nombre']; ?>
                        </div>
                    <?php }else{?>
                        <a href="<?= Parameters::$BASE_URL?>Comunidades/verComunidad?nombreComunidad=<?= $contenido['nombre_comunidad']?>">
                        <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['image_comunidad'] ?>" alt="imagen" class="imagenLogo-section">
                        </a>
                        <div class="nombre-section">
                            <?= "c/" . $contenido['nombre_comunidad']; ?>
                        </div>
                    <?php }?>
                    <div class="fecha-section"><?= $contenido['fecha_creacion'] ?></div>
                    <?php if ($contenido['esta_unido'] == 0 && $contenido['tipo_post'] === "comunidad") { ?>
                        <div class="unirseBoton-section unirse"
                            data-token-unirse="<?= $token[$contenido['id_post']] ?>">
                            Unirse
                        </div>
                    <?php } else { ?>

                    <?php } ?>
                </div>
                <div class="section-card">
                    <div class="titulo-section"><?= $contenido['titulo'] ?></div>
                    <div class="contenido-section"><?= $contenido['contenido'] ?></div>

                    <?php if (!empty($contenido['video'])): ?>
                        <!-- si existe video -->
                        <div class="videos-fotos-section">
                            <video class="video-section" controls>
                                <source src="<?= Parameters::$BASE_URL . 'assets/videos/' . $contenido['video'] ?>" type="video/mp4">
                                Tu navegador no soporta la etiqueta de video.
                            </video>
                        </div>
                    <?php elseif (!empty($contenido['imagen'])): ?>
                        <!-- si existe imagen -->
                        <div class="videos-fotos-section">
                            <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen'] ?>" alt="imagen" class="imagen-section">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="pie-section">
                    <div class="votos-seccion votar"
                        data-token-votar="<?= $token[$contenido['id_post']] ?>">
                        Votos(<?= $contenido['votos'] ?>)
                    </div>
                    <div class="comentarios-section">Comentarios</div>
                    <div class="compartir-section">Compartir</div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div id="loading"></div>
</section>