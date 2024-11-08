<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css">
    <link rel="stylesheet" href="public/css/logeado.css">
    <script src="public/js/scriptLogeado.js"></script>
    <title>Foro:logeado</title>
</head>
<style>
    a{
        text-decoration: none;
    }
</style>

<body>
    <div class="grid">
        <header>
            <div class="header">
                <div class="logo">
                    <div class="bars">☰</div>
                    <img src="public/img/logo1.jpg" alt="" class="logo-header">
                </div>
                <div class="perfil">
                    <a class="CrearPost" href="index.php?ctl=vistaPost" style="text-decoration: none;">Crear Post</a> 
                    <div class="nombre-usuario"><?php echo $_SESSION["nombre"] ?></div>
                    <img src="public/img/<?php echo $_SESSION["imagen_logo_usuario"] ?>" alt="">
                </div>
            </div>
        </header>
        <aside>
            <div class="aside1">
                <a id="textoAside" class="home"> <i class="fa fa-home"></i> Home</a>
                <a id="textoAside" class="popular"> <i class="fa fa-line-chart"></i>Popular </a>
                <a href="index.php?ctl=mostrarExplorar" class="explorar"> <i class="fa fa-users"></i>Explorar </a>
                <a id="textoAside" class="todasComunidades"> <i class="fa-solid fa-users"></i>Todos </a>
                <div class="recientes">Recientes <i class="fa fa-sort-down"></i></div>
                <div class="logo-texto">
                    <img src="public/img/administrador2.png" alt="foto">
                    <div id="textoAside1">ESTEBASND</div>
                </div>
                <div class="logo-texto">
                    <img src="public/img/administrador3.png" alt="foto">
                    <div id="textoAside1">ESTEBASND</div>
                </div>

                <div class="comunidades">Comunidades <i class="fa fa-sort-down"></i></div>

                <div class="logo-texto">
                    <i class="fa fa-plus"></i>
                    <div id="textoAside1">Crea una comunidad</div>
                </div>
                <div class="logo-texto">
                    <img src="public/img/administrador3.png" alt="foto">
                    <div id="textoAside1">comunidad 1</div>
                </div>
                <div class="logo-texto">
                    <img src="public/img/administrador3.png" alt="foto">
                    <div id="textoAside1">comunidad 2</div>
                </div>
               

            </div>
        </aside>
        <section>
        <div class="section">
    <?php foreach($datos as $indice => $contenido) {
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
        <footer>pie </footer>
    </div>


</body>

</html>