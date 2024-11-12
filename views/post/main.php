<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

$post = $data['post'] ?? NULL;


?>

    <section>
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

<!-- Ventana modal iniciar sesion .------------------------------------------------------ -->
<div class="modalIniciarSesion" id="modal-IniciarSesion">
    <div class="modal-content-sesion">
        <div class="cerrar">x</div>
        <div class="titulo-iniciarSesion">Iniciar Sesión</div>
        <form action="<?php Parameters::$BASE_URL ?>Usuario/iniciarSesion"method="post">
            <label for="nombre">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre de usuario" required>
            </label>
            <label for="contreaseña">
                <input type="password" name="contrasena" id="contraseña" placeholder="Contraseña" required>
            </label>
            <input type="submit" value="Iniciar Sesion">
        </form>
        <div class="texto-registro">¿Es tu primera vez en Foro? <a class="botonRegistrarse" >Registrarse</a></div>
    </div>
</div>
<!-- ventana modal registrarse ----------------------------------------------------------------- -->
<div class="modalRegistrar" id="modal-registrarse">
    <div class="modal-content-registrarse">
        <div class="cerrar">x</div>
        <div class="titulo-registrarse">Registrarse</div>
        <form action="<?php Parameters::$BASE_URL?> Usuario/registrarUsuarios" method="post">
            <label for="nombre">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre de usuario" required>
            </label>
            <label for="apellido">
                <input type="text" name="apellido" id="apellido" placeholder="apellido" required>
            </label>
            <label for="correo">
                <input type="email" name="email" id="email" placeholder="email" required>
            </label>
            <label for="contraseña">
                <input type="password" name="contraseña" id="contraseña " placeholder="contraseña" required>
            </label>
            <label for="repetir_contraseña">
                <input type="password" name="repetir_contraseña" id="repetir_contraseña" placeholder="Repetircontreaseña" required>
            </label>
            <input type="submit" value="Registrarse ">
        </form>
    </div>
</div>