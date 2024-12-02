<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;
$_SESSION['cambioVista']=false;
$post = $data['post'] ?? NULL;

?>

    <section id="sectionPopularNoLogeado">
        <div class="section">
            <?php foreach ($post as $indice => $contenido) {
            ?>
                <div class="card-section">
                    <div class="encabezado-section">
                        <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen_logo_usuario'] ?>" alt="imagen " class="imagenLogo-section">
                        <div class="nombre-section"><?php
                                                    if ($contenido['tipo_post'] === 'normal') {
                                                        echo 'n/' . $contenido['nombre'];
                                                    } elseif ($contenido['tipo_post'] === 'comunidad') {
                                                        echo 'c/' . $contenido['nombre'];
                                                    }
                                                    ?>
                        </div>
                        <div class="fecha-section"><?= $contenido['fecha_creacion'] ?></div>
                        <div class="unirseBoton-section">Unirse</div>
                    </div>
                    <div class="section-card">
                        <div class="titulo-section"><?= $contenido['titulo'] ?></div>
                        <div class="contenido-section"><?= $contenido['contenido'] ?> </div>
                        <?php if (!empty($contenido['video'])) { ?>
                            <!-- si existe video -->
                            <div class="videos-fotos-section">
                                <video class="video-section " controls>
                                    <source src="<?= Parameters::$BASE_URL . 'assets/videos/' . $contenido['video'] ?>" type="video/mp4">
                                    Tu navegador no soporta la etiqueta de video.
                                </video>
                            </div>
                        <?php } elseif (!empty($contenido['imagen'])) { ?>
                            <!-- si existe video -->
                            <div class="videos-fotos-section">
                                <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen'] ?>" alt="imagen" class="imagen-section">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="pie-section">
                        <div class="votos-seccion">votos</div>
                        <div class="comentarios-section">Comentarios</div>
                        <div class="compartir-section">Compartir</div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

