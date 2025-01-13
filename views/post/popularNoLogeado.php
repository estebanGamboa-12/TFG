<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;
$post = $data['post'] ?? NULL;
?>
<?php
if (isset($_SESSION['mensaje'])) {
    echo '<div class="mensaje id="mensaje"">';
    echo $_SESSION['mensaje'];
    echo '</div>';
    unset($_SESSION['mensaje']);
}

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
<section id="sectionPopularNoLogeado">
    <div class="section">
        <?php if (!empty($post)): ?>
            <?php foreach ($post as $indice => $contenido): ?>
                <div class="card-section">
                    <div class="encabezado-section">
                        <a href="<?= Parameters::$BASE_URL ?>Usuario/verUsuario?nombre=<?= $contenido['nombre'] ?>">
                            <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen_logo_usuario'] ?>"
                                alt="imagen" class="imagenLogo-section">
                        </a>
                        <div class="nombre-section"><?php
                        if ($contenido['tipo_post'] === 'normal') {
                            echo 'n/' . $contenido['nombre'];
                        } elseif ($contenido['tipo_post'] === 'comunidad') {
                            echo 'c/' . $contenido['nombre'];
                        }
                        ?></div>
                        <div class="fecha-section"><?= $contenido['fecha_creacion'] ?></div>
                        <div class="unirseBoton-section">Unirse</div>
                    </div>
                    <div class="section-card">
                        <div class="titulo-section"><?= $contenido['titulo'] ?></div>
                        <div class="contenido-section"><?= $contenido['contenido'] ?> </div>
                        <?php if (!empty($contenido['video'])): ?>
                            <div class="videos-fotos-section">
                                <video class="video-section" controls>
                                    <source src="<?= Parameters::$BASE_URL . 'assets/videos/' . $contenido['video'] ?>"
                                        type="video/mp4">
                                    Tu navegador no soporta la etiqueta de video.
                                </video>
                            </div>
                        <?php elseif (!empty($contenido['imagen'])): ?>
                            <div class="videos-fotos-section">
                                <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen'] ?>" alt="imagen"
                                    class="imagen-section">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="pie-section">
                        <div class="votos-seccion votar">votos</div>
                        <div class="comentarios-section">Comentarios</div>
                    </div>
                </div>
                
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay publicaciones disponibles.</p>
        <?php endif; ?>
    </div>
</section>