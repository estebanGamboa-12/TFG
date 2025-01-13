<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

$post = $data['post'] ?? NULL;
$token = $data['token'] ?? NULL;
$usuario = $data['usuario'] ?? NULL;


$idUsuario = $_SESSION['user']['idUsuario'] ?? NULL;
?>
<pre>
    <?php //var_dump($post);exit; 
    ?>
</pre>
<style>
    .alert {
        display: flex;
        justify-content: center;
        background: #ff000073;
        padding: 2%;
        border-radius: 3rem;
    }
</style>
<?php
if (!empty($_SESSION['errores'])) {
    echo '<div class="error-container">';
    echo '<div class="error-messages">';
    echo '<ul>';
    foreach ($_SESSION['errores'] as $error) {
        echo "<li>$error</li>";
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    unset($_SESSION['errores']);
}
?>
<section id="section">
    <div class="containerEncabezadoVer">
        <div id="nombreImagenVer">
            <i class="material-icons back" onclick="back()">arrow_back</i>
            <img src="<?= Parameters::$BASE_URL ?>assets/img/<?= $usuario['imagen_logo_usuario'] ?>" alt="foto">
            <span>n/ <?= $usuario['nombre'] ?></span>
        </div>
    </div>
    <div class="section">
        <div class="contenidoMensajes"></div>
        <?php if (empty($post)) {
            echo '<div class="alert alert-danger">No hay post para mostrar</div>';
        } else { ?>
            <?php foreach ($post as $indice => $contenido): ?>
                <div class="card-section" data-token-comentar="<?= $token[$contenido['id_post']] ?>">
                    <div class="encabezado-section">
                        <?php if ($contenido['tipo_post'] === "normal") { ?>
                            <a href="<?= Parameters::$BASE_URL ?>Usuario/verUsuario?nombre=<?= $usuario['nombre'] ?>">
                                <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $usuario['imagen_logo_usuario'] ?>"
                                    alt="imagen" class="imagenLogo-section">
                            </a>
                            <div class="nombre-section">
                                <?= "n/" . $usuario['nombre']; ?>
                            </div>
                        <?php } else { ?>
                            <a
                                href="<?= Parameters::$BASE_URL ?>Comunidades/verComunidad?nombreComunidad=<?= $contenido['nombre_comunidad'] ?>">
                                <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen_comunidad'] ?>"
                                    alt="imagen" class="imagenLogo-section">
                            </a>
                            <div class="nombre-section">
                                <?= "c/" . $contenido['nombre_comunidad']; ?>
                            </div>
                        <?php } ?>
                        <div class="fecha-section"><?= $contenido['fecha_creacion'] ?></div>
                        <?php if ($contenido['esta_unido'] == 0 && $contenido['tipo_post'] === "comunidad") { ?>
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
                                    <source src="<?= Parameters::$BASE_URL . 'assets/videos/' . $contenido['video'] ?>"
                                        type="video/mp4">
                                    Tu navegador no soporta la etiqueta de video.
                                </video>
                            </div>
                        <?php elseif (!empty($contenido['imagen'])): ?>
                            <!-- si existe imagen -->
                            <div class="videos-fotos-section">
                                <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen'] ?>" alt="imagen"
                                    class="imagen-section">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="pie-section">
                        <div class="votos-seccion votar" data-token-votar="<?= $token[$contenido['id_post']] ?>">
                            Votos(<?= $contenido['votos'] ?>)
                        </div>
                        <div class="comentarios-section">Comentarios</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="loading"></div>
    </section>
<?php } ?>
<script>
    function back() {
        window.history.back();
    }
</script>