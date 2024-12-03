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
                <div class="botonSeguirUsuario">
                    <span>seguir</span>
                </div>
            </div>
            <div class="datosUsuarioVer">
                <div id="datos">
                    <span><?= $datosUsuario['postsTotales'] ?></span>
                    <span class="tituloDatos">post</span>
                </div>
                <div id="datos">
                    <span><?= $datosUsuario['comentariosTotales'] ?></span>
                    <span  class="tituloDatos">Comentarios</span>
                </div>
                <div id="datos">
                    <span><?= $usuario['fecha_unido'] ?></span>
                    <span  class="tituloDatos">Fecha unido</span>
                </div>
            </div>
        </div>
        <style>
            .tituloDatos{
                color: #828282;
                margin-bottom: 4%;
            }
            .containerNombreBotonVer {
                display: flex;
                flex-direction: row;
            }

            .nombreUsuarioVer {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                margin: 5%;
            }

            .botonSeguirUsuario {
                display: flex;
                margin:  5%;
                margin-left: auto;
            }

            .botonSeguirUsuario span {
                border-radius: 1rem;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: rgb(0, 150, 136);
                font-family: Georgia, 'Times New Roman', Times, serif;
                color: black;
                font-size: 100%;
                width: 6rem;
                height: 2rem;
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

    </aside>
<?php } else if ($_SESSION['cambioVista'] == "perfilComunidades") { ?>
    <aside class="second-aside ">
        <div class="containerBotones">
            <a href="<?= Parameters::$BASE_URL ?>Post/mostrarForm">
                <div class="crearPost botones" id="crearPost">Crear Post</div>
            </a>
            <div class="unirseComunidad botones">Unirse</div>
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
        <style>
            #numeroMiembrosComunidad {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 3rem;
            }

            .nombreComunidad {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                margin-bottom: 2%;
            }

            .descripcionComunidad,
            .fechaComunidad {
                color: #828282;
                margin-bottom: 2%;
            }

            .botones {
                border-radius: 1rem;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: rgb(0, 150, 136);
                font-family: Georgia, 'Times New Roman', Times, serif;
                color: black;
                font-size: 100%;
                width: 6rem;
                height: 2rem;
            }

            .containerBotones {
                display: flex;
                flex-direction: row;
                justify-content: flex-start;
                align-items: center;
                margin-top: 5%;
            }

            .unirseComunidad {
                margin-left: 2rem;
            }

            .miembrosComunidad {
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
            }
        </style>

    </aside>
<?php } else if ($_SESSION['cambioVista'] == "") { ?>
    <aside class="second-aside ">
        <div>asdasd</div>
        <div class="aside2">
            <h2>
                asdasddfff
            </h2>
            <div class="containerNombreBotonVer">
                <div class="botonSeguirUsuario">
                    <span>unirse</span>
                </div>
            </div>

        </div>
    </aside>
<?php } ?>