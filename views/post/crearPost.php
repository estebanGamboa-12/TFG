<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

if(!Authentication::isUserLogged()){
    header("Location:" . Parameters::$BASE_URL);
}
?>

<section>
    <div class="section">
        <form action="<?= Parameters::$BASE_URL ?>Post/subirPost" method="post">
            <div class="CrearPublicaciones-titulo">
                <h2>Crear publicaciones</h2>
            </div>
            <div class="Crearpublicaciones-select">
                <label for="select-comunidad">Elige una fruta:</label>
                <select id="select-comunidad" name="comunidad">
                    <optgroup label="Tu perfil">
                        <option value="manzana"></option>
                    </optgroup>
                    <optgroup label="Tus comunidades">
                        <option value="comunidad1">comunidad1</option>
                        <option value="comunidad1"> comunidad2</option>
                    </optgroup>
                </select>
            </div>
            <div class="CrearPublicaciones-opciones">
                <div class="opcion-text">Text</div>
                <div class="opcion-imagen">Imagenes/videos</div>
                <div class="opcion-link">Link</div>
            </div>
            <div class="CrearPublicaciones-titulo">
                <input type="text" placeholder="Titulo" class="titulo-formulario">
            </div>
            <div class="caja-texto">
                <div class="CrearPublicaciones-contenido">
                    <textarea id="editor" name="texto" placeholder="Cuerpo"></textarea>
                </div>
            </div>
            <div class="caja-imagen">
                <div class="CrearPublicaciones-contenido">
                    <input type="file" name="imagen" id="imagen">
                </div>
            </div>
            <div class="caja-link">
                <div class="CrearPublicaciones-contenido">
                    <input type="text" name="link" placeholder="Link URL" class="titulo-formulario">
                </div>
            </div>
            <div class="CrearPublicaciones-botonPost">
                <input type="submit" value="Post">
            </div>
        </form>

    </div>
</section>

<script src="<?= Parameters::$BASE_URL . "assets/js/scriptLogeado.js" ?>"></script>