<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/estilos.css">
    <script src="public/js/script.js"></script>
    <title>Inicio</title>
</head>

<body>
    <div class="grid">
        <header>
            <div class="header">
                <div class="logo">
                    <div class="bars">☰</div>
                    <img src="public/img/logo1.jpg" alt="" class="logo-header">
                </div>
                <div class="tresPuntos">
                    <div class="iniciarSesion">Iniciar Sesion</div>
                    <i class="fa fa-ellipsis-h"></i>
                </div>
            </div>
        </header>
        <aside class="contenido-aside">
            <div class="aside1">
                <div class="popular">Popular <i class="fa fa-sort-down"></i></div>
                <div class="recientes">Recientes <i class="fa fa-sort-down"></i></div>
                <div class="logo-texto">
                    <img src="public/img/administrador2.png" alt="foto">
                    <div id="textoAside1">esteban</div>
                </div>
                <div class="logo-texto">
                    <img src="public/img/administrador4.png" alt="foto">
                    <div id="textoAside1">123</div>
                </div>
                <div class="temas">Temas <i class="fa fa-sort-down"></i></div>
                <div class="logo-texto">
                    <img src="public/img/administrador.png" alt="foto">
                    <div id="textoAside1">esteban123</div>
                </div>
                <div class="logo-texto">
                    <img src="public/img/administrador4.png" alt="foto">
                    <div id="textoAside1">ESTEBASND</div>
                </div>
                <div class="logo-texto comunidades">
                    <img src="public/img/administrador3.png" alt="foto">
                    <div id="textoAside1">Comunidades</div>
                </div>
            </div>
        </aside>
        <section>
            <div class="section">
            
    <?php foreach($datos as $indice => $contenido) {
        ?>
                <div class="card-section">
                    <div class="encabezado-section">
                        <img src="public/img/administrador3.png" alt="" class="imagenLogo-section">
                        <div class="nombre-section"><?=$contenido['titulo'] ?></div>
                        <div class="fecha-section"><?= $contenido['fecha_creacion'] ?></div>
                        <div class="unirseBoton-section">Unirse</div>
                    </div>
                    <div class="section-card">
                        <div class="titulo-section"><?= $contenido['titulo'] ?></div>
                        <div class="contenido-section"><?= $contenido['contenido'] ?> </div>
                    </div>
                    <div class="pie-section">
                        <div class="votos-seccion">votos</div>
                        <div class="comentarios-section">Comentarios</div>
                        <div class="compartir-section">Compartir</div>
                    </div>
                </div>
                <?php } ?>
                <!-- <div class="card-section">
                    <div class="encabezado-section">
                        <img src="public/img/administrador3.png" alt="" class="imagenLogo-section">
                        <div class="nombre-section">Esteban</div>
                        <div class="fecha-section">13/08/2002</div>
                        <div class="unirseBoton-section">Unirse</div>
                    </div>
                    <div class="section-card">
                        <div class="titulo-section">titulo</div>
                        <div class="contenido-section"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum
                            laborum sit, asperiores fugiat ratione porro a amet magnam tempore quia qui officiis ipsa,
                            eius
                            minus laudantium explicabo consectetur, temporibus aspernatur?</div>
                        <div class="videos-fotos-section">
                            <video class="video-section " controls>
                            <source src="public\videos\215484_tiny.mp4" type="video/mp4">
                                Tu navegador no soporta la etiqueta de video.
                            </video>
                        </div>
                    </div>
                    <div class="pie-section">
                        <div class="votos-seccion">votos</div>
                        <div class="comentarios-section">Comentarios</div>
                        <div class="compartir-section">Compartir</div>
                    </div>
                </div>
                <div class="card-section">
                    <div class="encabezado-section">
                        <img src="public/img/administrador3.png" alt="" class="imagenLogo-section">
                        <div class="nombre-section">esteban</div>
                        <div class="fecha-section">13/08/2002</div>
                        <div class="unirseBoton-section">Unirse</div>
                    </div>
                    <div class="section-card">
                        <div class="titulo-section">Toma croasant rico rico de pelotas manito</div>
                        <div class="contenido-section"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum
                            laborum sit, asperiores fugiat ratione porro a amet magnam tempore quia qui officiis ipsa,
                            eius
                            minus laudantium explicabo consectetur, temporibus aspernatur?</div>
                        <div class="videos-fotos-section">
                            <img src="public/img/manzana.jpg" alt="imagen" class="imagen-section">
                        </div>
                    </div>
                    <div class="pie-section">
                        <div class="votos-seccion">votos</div>
                        <div class="comentarios-section">Comentarios</div>
                        <div class="compartir-section">Compartir</div>
                    </div>
                </div> -->
            </div>
        </section>
        <aside>
            <div class="aside2">
                <div class="comunidades-aside">Comunidades Populares</div>
                <div class="card-aside2">
                    <div class="titulo-aside">
                        <img src="public/img/administrador3.png" alt="" class="imagenLogo-section">
                        <div class="nombre-aside">
                            <div class="nombre-aside"> Esteban</div>
                            <div class="miembros-aside">34.2mill miembros</div>
                        </div>
                    </div>
                </div>
                <div class="card-aside2">
                    <div class="titulo-aside">
                        <img src="public/img/administrador3.png" alt="" class="imagenLogo-section">
                        <div class="nombre-aside">
                            <div class="nombre-aside"> Esteban</div>
                            <div class="miembros-aside">34.2mill miembros</div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <footer>pie </footer>
    </div>
    <!-- Ventana modal que la pulsar el votón de iniciar sesion se muestra -->
    <div class="modalIniciarSesion" id="modal-IniciarSesion">
        <div class="modal-content-sesion">
            <div class=" cerrar">x</div>
            <div class="titulo-iniciarSesion">Iniciar Sesión</div>
            <form action="app/controladores/ControllerUsuario.php" method="post">
                <label for="nombre">
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre de usuario" required>
                </label>
                <label for="contreaseña">
                    <input type="password" name="contraseña" id="contraseña" placeholder="Contraseña" required>
                </label>

                <input type="submit" value="Iniciar Sesion">
            </form>
            <div class="texto-registro">¿Es tu primera vez en Foro? <a href="#">Registrarse</a></div>
        </div>
    </div>
</body>

</html>