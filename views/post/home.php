<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

$post = $data['post'] ?? NULL;
$token = $data['token'] ?? NULL;


$idUsuario = $_SESSION['user']['idUsuario'] ?? NULL;
?>

<pre>
    <?php //var_dump($post);exit; 
    ?>
</pre>
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
<script>
    // Función para ocultar el mensaje después de 3 segundos
    setTimeout(function() {
        var mensaje = document.getElementById('mensaje');
        var errores = document.getElementById('errores');
        if (mensaje) {
            mensaje.style.display = 'none';
        }
        if (errores) {
            errores.style.display = 'none';
        }
    }, 2000); // 3000 milisegundos = 3 segundos
</script>
<section id="sectionHome">
    <div class="section">
        <div class="contenidoMensajes"></div>
        <?php foreach ($post as $indice => $contenido): ?>
            <a href="<?= Parameters::$BASE_URL ?>Comentarios/verVistaComentarios">
                <div class="card-section" data-token-comentar="<?= $token[$contenido['id_post']] ?>">
                    <div class="encabezado-section">
                        <?php if ($contenido['tipo_post'] === "normal") { ?>
                            <a href="<?= Parameters::$BASE_URL ?>Usuario/verUsuario?nombre=<?= $contenido['nombre'] ?>">
                                <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen_logo_usuario'] ?>" alt="imagen" class="imagenLogo-section">
                            </a>
                            <div class="nombre-section">
                                <?= "n/" . $contenido['nombre']; ?>
                            </div>
                        <?php } else { ?>
                            <a href="<?= Parameters::$BASE_URL ?>Comunidades/verComunidad?nombreComunidad=<?= $contenido['nombre_comunidad'] ?>">
                                <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['image_comunidad'] ?>" alt="imagen" class="imagenLogo-section">
                            </a>
                            <div class="nombre-section">
                                <?= "c/" . $contenido['nombre_comunidad']; ?>
                            </div>
                        <?php } ?>
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
                        <div class="contenido-section">
                            <?php
                            $contenido_texto = trim($contenido['contenido']); // Elimina los espacios alrededor del texto
                            if (strpos($contenido_texto, 'http') !== false) { ?>
                                <a href="#" class="link" style="color: blue; border-block-end: 1px solid blue;"><?= $contenido_texto ?></a>
                            <?php } else { ?>
                                <div> <?= $contenido_texto ?></div>
                            <?php } ?>
                        </div>
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
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <div id="loading"></div>
</section>
<script>
    if (document.querySelector(".link")) {
        document.querySelector(".link").addEventListener("click", (e) => {
            let valorLink = e.value;
            console.log(valorLink);
            window.open(valorLink, '_blank');
        })
    }
</script>