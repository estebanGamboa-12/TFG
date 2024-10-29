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
        <aside class="contenido-aside first-aside">
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
                <?php
                 foreach($datos['temas'] as $indice=>$contenido){ ?>
                <div class="logo-texto">
                    <img src="public/img/administrador.png" alt="foto">
                    <div id="textoAside1"><?= $contenido['nombre_tema']?></div>
                </div>
                <?php }?>
                
                <div class="logo-texto comunidades">
                    <img src="public/img/administrador3.png" alt="foto">
                    <div id="textoAside1">Comunidades</div>
                </div>
            </div>
        </aside>
        <section>
            <div class="section">
    <?php foreach($datos['post'] as $indice => $contenido) {
      
        ?>
                <div class="card-section">
                    <div class="encabezado-section">
                        <img src="public/img/<?=$contenido['imagen_logo_usuario'] ?>" alt="" class="imagenLogo-section">
                        <div class="nombre-section"><?php
                                if($contenido['tipo_post']==='normal'){
                                    echo 'n/' .$contenido['nombre'] ;
                                }elseif($contenido['tipo_post']==='comunidad'){
                                    echo 'c/' .$contenido['nombre'] ;
                                }
                         ?>
                        </div>
                        <div class="fecha-section"><?= $contenido['fecha_creacion'] ?></div>
                        <div class="unirseBoton-section">Unirse</div>
                    </div>
                    <div class="section-card">
                        <div class="titulo-section"><?= $contenido['titulo'] ?></div>
                        <div class="contenido-section"><?= $contenido['contenido'] ?> </div>
                        <?php if(!empty($contenido['video'])){ ?>
                        <!-- si existe video -->
                        <div class="videos-fotos-section">
                            <video class="video-section " controls>
                            <source src="public\videos\<?=$contenido['video']?>" type="video/mp4">
                                Tu navegador no soporta la etiqueta de video.
                            </video>
                        </div>
                        <?php }elseif(!empty($contenido['imagen'])){?>
                        <!-- si existe video -->
                        <div class="videos-fotos-section">
                            <img src="public/img/<?=$contenido['imagen']?>" alt="imagen" class="imagen-section">
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
        <aside class="second-aside">
            <div class="aside2">
                <div class="comunidades-aside">Comunidades Populares</div>
                <?php foreach($datos['comunidades'] as $indice=>$contenido) {?>
                <div class="card-aside2">
                    <div class="titulo-aside">
                        <img src="public/img/<?= $contenido['comunidad_imagen'] ?>" alt="" class="imagenLogo-section">
                        <div class="nombre-aside">
                            <div class="nombre-aside"> <?= $contenido['comunidad_nombre'] ?></div>
                            <div class="miembros-aside"><?= $contenido['total_miembros'] ?> miembros</div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </aside>
        <footer> 
        </footer>
    </div>
    <!-- Ventana modal iniciar sesion .------------------------------------------------------ -->
    <div class="modalIniciarSesion" id="modal-IniciarSesion">
        <div class="modal-content-sesion">
            <div class=" cerrar">x</div>
            <div class="titulo-iniciarSesion">Iniciar Sesión</div>
            <form action="index.php?ctl=iniciarSesion" method="post">
                <label for="nombre">
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre de usuario" required>
                </label>
                <label for="contreaseña">
                    <input type="password" name="contrasena" id="contraseña" placeholder="Contraseña" required>
                </label>

                <input type="submit" value="Iniciar Sesion">
            </form>
            <div class="texto-registro">¿Es tu primera vez en Foro? <a class="botonRegistrarse" href="#">Registrarse</a></div>
        </div>
    </div>
    <!-- ventana modal registrarse ----------------------------------------------------------------- -->
    <div class="modalRegistrar" id="modal-registrarse" >
        <div class="modal-content-registrarse">
            <div class="cerrar">x</div>
            <div class="titulo-registrarse">Registrarse</div>
            <form action="index.php?ctl=registrar" method="post">
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
    
</body>

</html>