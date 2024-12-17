<?php

use admin\foro\Config\Parameters;
?>


<?php if ($_SESSION['cambioVista'] == "todasComunidades") { ?>
    <aside class="second-aside ">
        <div class="aside2">
            <div class="comunidades-aside">Comunidades Populares</div>
            <?php foreach ($comunidades as $indice => $contenido) { ?>
                <div class="card-aside2">
                    <img class="imagenLogo-aside" src="<?= Parameters::$BASE_URL . "assets/img/" . $contenido['imagen'] ?>" alt="foto">
                    <div class="contenido-aside2">
                        <div class="nombre-aside"><?= $contenido['nombre'] ?></div>
                        <div class="miembros-aside"><?= $contenido['numero_de_usuarios'] ?> miembros</div>
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
        <div class="containerBotones">
            <?php if ($datosComunidad["usuario_unido"] == "1") { ?>
                    
            <?php } else { ?>
                <div class="unirseComunidad botones">Unirse </div>
            <?php  } ?>
        </div>
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

<?php } else if ($_SESSION['cambioVista'] == "cerrarSesion") { ?>
    <aside class="second-aside ">
        <div class="aside2 asideCerrarSesion">
            <div>Editar Usuario</div>
            <div class="boton cerrarSesion"> <a href="<?= Parameters::$BASE_URL ?>Usuario/cerrarSesion">Cerrar Sesion </a></div>
        </div>
    </aside>
<?php } else if ($_SESSION['cambioVista'] == "") { ?>
    <aside class="second-aside ">
    </aside>
<?php } ?>