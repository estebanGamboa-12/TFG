<?php 
use admin\foro\Config\Parameters;
$verUsuarios=$_SESSION['cambioVista'];

?>

<?php if($verUsuarios==false){ ?>
 <aside class="second-aside ">
    <div class="aside2">
        <div class="comunidades-aside">Comunidades Populares</div>
        <?php foreach ($comunidades as $indice => $contenido) { ?>
        <div class="card-aside2">
            <img class="imagenLogo-aside" src="<?= Parameters::$BASE_URL . "assets/img/".$contenido['imagen']?>" alt="foto">
            <div class="contenido-aside2">
            <div class="nombre-aside"><?= $contenido['nombre']?></div>
            <div class="miembros-aside"><?=$contenido['numero_de_usuarios']?> miembros</div>
            </div>
        </div>
        <?php }?>
    </div>
</aside> 
<?php }else if ($verUsuarios){ ?>
 <aside class="second-aside ">
    <div class="aside2">
        <div class="containerNombreBotonVer">
            <span class="nombreUsuarioVer"><?= $usuario['nombre']?></span>
            <div class="botonSeguirUsuario">
                <span>seguir</span>
            </div>
        </div>
        <div class="datosUsuarioVer">
            <div id="datos">
                <span><?= $datosUsuario['postsTotales']?></span>
                <span>post</span>
            </div>
            <div id="datos">
                <span><?= $datosUsuario['comentariosTotales']?></span>
                <span>Comentarios</span>
            </div>
            <div id="datos">
                <span><?= $usuario['fecha_unido']?></span>
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
            background-color: rgb(0, 150, 136);
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

</aside> 
<?php } ?>
