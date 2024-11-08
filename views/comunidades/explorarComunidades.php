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
    a {
        text-decoration: none;
    }

    #card-comunidades {
        border-radius: 1rem;
        display: flex;
        padding: 1%;
        border: 1px solid gray;
        width: 15rem;
        margin: 3% 3%;
        flex-direction: column;
    }

    .parteArriba {
        display: flex;
        justify-content: space-between;

    }

    .parteAbajo {
        display: flex;
        justify-content: flex-start;
        margin-top: 5%;
    }

    .conteiner-comunidades {
        display: flex;
        flex-wrap: wrap;
    }

    .logo-comunidades {
        border-radius: 1rem;
        width: 2rem;
        height: 2rem;
    }
    section {
    grid-column: 2 / 4;
    grid-row: 2;
    margin: 0% 3%;
    overflow-y: auto;
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

                <div class="conteiner-comunidades">
                    <?php foreach ($comunidades as $indice => $contenido) {
                    ?>
                        <div id="card-comunidades">
                            <div class="parteArriba">
                                <img src="public/img/<?php echo $contenido["imagen"] ?>"alt="" class="logo-comunidades">
                                <div><?php echo $contenido['nombre'] ?>
                                    <div>10M members</div>
                                </div>
                                <div>join</div>
                            </div>
                            <div class="parteAbajo">
                                <?php echo $contenido['descripcion'] ?>
                            </div>
                        </div>
                
            <?php  } ?>
            </div>
            </div>
    </div>
    </section>
    <footer>pie </footer>
    </div>


</body>

</html>