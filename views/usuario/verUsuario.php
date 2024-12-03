<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

$post = $data['post'] ?? NULL;
$token = $data['token'] ?? NULL;
$usuario = $data['usuario'] ?? NULL;


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

    .containerEncabezadoVer {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        margin-top: 3%;

    }

    #nombreImagenVer {
        display: flex;
        flex-direction: row;
        width: 25%;
        justify-content: space-between;
    }

    #nombreImagenVer img {
        border-radius: 50%;
        width: 3rem;
        height: 3rem;
    }


    .botonesVer {
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
        width: 100%;
    }

    .botonesVer span {
        background-color: green;
        color: #f3f3f3;
        padding: 1% 2%;
        border-radius: 1rem;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0% 2%;
    }
</style>
<pre>
    <?php //var_dump($post);exit; 
    ?>
</pre>
<section id="section">
    <div class="containerEncabezadoVer">
        <div id="nombreImagenVer">
            <img src="<?= Parameters::$BASE_URL ?>assets/img/<?=$usuario['imagen_logo_usuario'] ?>" alt="foto culo">
            <span>n/ <?= $usuario['nombre']?></span>
        </div>
        <div class="botonesVer">
            <span>Crear post</span>
        </div>
    </div>
        <div class="section">
        <div class="contenidoMensajes"></div>
        <?php foreach ($post as $indice => $contenido): ?>
            <div class="card-section">
                <div class="encabezado-section">
                    <?php if ($contenido['tipo_post'] === "normal") { ?>
                        <a href="<?= Parameters::$BASE_URL ?>Usuario/verUsuario?nombre=<?= $usuario['nombre'] ?>">
                            <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $usuario['imagen_logo_usuario'] ?>" alt="imagen" class="imagenLogo-section">
                        </a>
                        <div class="nombre-section">
                            <?= "n/" . $usuario['nombre']; ?>
                        </div>
                    <?php } else { ?>
                        <a href="<?= Parameters::$BASE_URL ?>Comunidades/verComunidad?idComunidad=<?= $contenido['id_comunidad'] ?>">
                            <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen_comunidad'] ?>" alt="imagen" class="imagenLogo-section">
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
<!-- <aside class="second-aside ">
    <div class="aside2">
        <div class="containerNombreBotonVer">
            <span class="nombreUsuarioVer">nombre usuario</span>
            <div class="botonSeguirUsuario">
                <span>seguir</span>
            </div>
        </div>
        <div class="datosUsuarioVer">
            <div id="datos">
                <span>70</span>
                <span>post</span>
            </div>
            <div id="datos">
                <span>57</span>
                <span>Comentarios</span>
            </div>
            <div id="datos">
                <span>11/28/2024</span>
                <span>Fecha unido</span>
            </div>
        </div>
    </div>
    <style>
        .containerNombreBotonVer {
            display: flex;
            flex-direction: row;
        }

        .nombreUsuarioVer {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin: 10% 0% 0% 5%;
        }

        .botonSeguirUsuario {
            display: flex;
            margin: 10% 5%;
            margin-left: auto;
        }

        .botonSeguirUsuario span {
            border-radius: 1rem;
            padding: 1rem;
            background-color: greenyellow;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 0;
        }

        .datosUsuarioVer {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        #datos {
            display: flex;
            flex-direction: column;
        }
    </style>

</aside> -->