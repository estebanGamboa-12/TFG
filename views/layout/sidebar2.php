<?php

use admin\foro\Config\Parameters;
?>

<?php  if(isset($_SESSION['cambioVista'])){?>

<?php if ($_SESSION['cambioVista'] == "todasComunidades") { ?>
    <aside class="second-aside ">
        <div class="aside2">
            <div class="comunidades-aside">Comunidades Populares</div>
            <?php foreach ($comunidades as $indice => $contenido) { ?>
                <div class="card-aside2">
                    <img class="imagenLogo-aside" src="<?= Parameters::$BASE_URL . "assets/img/" . $contenido['imagen'] ?>" alt="foto">
                    <div class="contenido-aside2">
                        <div class="nombre-aside"><?= $contenido['nombre'] ?></div>
                        <div class="miembros-aside"><?= $contenido['numero_usuarios'] ?> miembros</div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </aside>
<?php } else if ($_SESSION['cambioVista'] == "perfilUsuario") { ?>
    <aside class="second-aside ">
        <div class="aside2">
            <div class="containerNombreBotonVer">
                <span class="nombreUsuarioVer"><?= $usuario['nombre'] ?></span>
            </div>
            <div class="datosUsuarioVer">
                <div id="datos">
                    <span><?= $datosUsuario['postsTotales'] ?></span>
                    <span class="tituloDatos">post</span>
                </div>
                <div id="datos">
                    <span><?= $datosUsuario['comentariosTotales'] ?></span>
                    <span class="tituloDatos">Comentarios</span>
                </div>
                <div id="datos">
                    <span><?= $usuario['fecha_unido'] ?></span>
                    <span class="tituloDatos">Fecha unido</span>
                </div>
            </div>
        </div>
    </aside>
<?php } else if ($_SESSION['cambioVista'] == "perfilComunidades") { ?>
    <aside class="second-aside ">
       
        <div class="aside2">
            <div class="nombreComunidad"><?= $datosComunidad['nombre'] ?></div>
            <div class="descripcionComunidad"><?= $datosComunidad['descripcion'] ?></div>
            <div class="fechaComunidad"> Creado:<?= $datosComunidad['fecha_creacion'] ?></div>
            <div class="miembrosComunidad">
                <span id="numeroMiembrosComunidad"><?= $datosComunidad['numero_usuarios'] ?></span>
                <div>Miembros</div>
            </div>
        </div>
    </aside>
    <?php } else if ($_SESSION['cambioVista'] == "verPostRecientes") {
    if ($postRecientes == NULL) { ?>

    <?php } else { ?>
        <aside class="second-aside">
            <div style="display: flex;flex-direction: row; justify-content: flex-start;margin-top: 5%;padding-right: 9%;">
                <h2>Post recientes</h2>
                <a style="margin-left:42%;" href="<?= Parameters::$BASE_URL ?>Post/borrarPostRecientes">Borrar</a>
            </div>
            <div class="recent-post-container">
                <?php foreach ($postRecientes as $post) {
                    if ($post['tipo_post'] == "comunidad") { ?>
                        <div class="post-card">
                            <div class="post-icon">
                                <img src="<?= Parameters::$BASE_URL ?>assets/img/<?= $post['imagen_comunidad'] ?>" alt="Icono del subreddit">
                            </div>
                            <div class="post-content">
                                <span class="post-title">c/<?= $post['nombre_comunidad'] ?></span>
                                <p class="post-description"><?= $post['contenido'] ?></p>
                                <div class="post-footer">
                                    <span><?= $post['votos_totales'] ?> votos</span> · <span><?= $post['votos_totales'] ?> comments</span>
                                </div>
                            </div>
                            <?php if ($post['video'] == NULL && $post['imagen'] == NULL) { ?>
                                <!-- Aquí puedes agregar contenido si no hay video ni imagen -->
                            <?php } else if ($post['video'] == NULL) { ?>
                                <div class="post-thumbnail">
                                    <img src="<?= Parameters::$BASE_URL ?>assets/img/<?= $post['imagen'] ?>" alt="imagen post">
                                </div>
                            <?php } else { ?>
                                <div class="post-thumbnail">
                                    <video src="<?= Parameters::$BASE_URL ?>assets/video/<?= $post['video'] ?>" alt="Miniatura del video">
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="post-card">
                            <div class="post-icon">
                                <img src="<?= Parameters::$BASE_URL ?>assets/img/<?= $post['imagen_logo_usuario'] ?>" alt="Icono del subreddit">
                            </div>
                            <div class="post-content">
                                <span class="post-title">u/<?= $post['nombre_usuario'] ?></span>
                                <p class="post-description"><?= $post['contenido'] ?></p>
                                <div class="post-footer">
                                    <span><?= $post['votos_totales'] ?> votos</span> · <span><?= $post['votos_totales'] ?> comments</span>
                                </div>
                            </div>
                            <?php if ($post['video'] == NULL && $post['imagen'] == NULL) { ?>
                                <!-- Aquí puedes agregar contenido si no hay video ni imagen -->
                            <?php } else if ($post['video'] == NULL) { ?>
                                <div class="post-thumbnail">
                                    <img src="<?= Parameters::$BASE_URL ?>assets/img/<?= $post['imagen'] ?>" alt="imagen post">
                                </div>
                            <?php } else { ?>
                                <div class="post-thumbnail">
                                    <video src="<?= Parameters::$BASE_URL ?>assets/video/<?= $post['video'] ?>" alt="Miniatura del video">
                                </div>
                            <?php } ?>
                        </div>
                <?php }
                } ?>
            </div>
        </aside>
    <?php } ?>
<?php } else if ($_SESSION['cambioVista'] == "") { ?>
<?php } 
}else{?>
    
<?php }?>
<style>
    /* Estilo del contenedor general */

    h2 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #333;
    }

    /* Estilo para la tarjeta de cada post */
    .recent-post-container {
        display: flex;
        flex-direction: column;
        /* Ajuste inicial para pantallas pequeñas */
        gap: 15px;
    }

    .post-card {
        display: flex;
        flex: 1;
        flex-direction: row;
        align-items: center;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        padding: 10px;
        gap: 10px;
        flex-wrap: wrap;
    }

    .post-icon img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    /* Contenido del post */
    .post-content {
        flex: 1;
        min-width: 150px;
        /* Evita que se colapse en pantallas muy pequeñas */
    }

    .post-title {
        font-size: 14px;
        font-weight: bold;
        color: #555;
    }

    .post-description {
        font-size: 14px;
        margin: 5px 0;
        color: #333;
    }

    .post-footer {
        font-size: 12px;
        color: #777;
    }

    /* Miniatura del video */
    .post-thumbnail {
        position: relative;
        flex-shrink: 0;
    }

    .post-thumbnail img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
    }

    .video-duration {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        font-size: 10px;
        padding: 2px 5px;
        border-radius: 3px;
    }
</style>