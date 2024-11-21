<?php 
use admin\foro\Config\Parameters;
?>


<aside class="second-aside ">
    <div class="aside2">
        <div class="comunidades-aside">Comunidades Populares</div>
        <?php foreach ($comunidades as $indice => $contenido) { ?>
        <div class="card-aside2">
            <img class="imagenLogo-aside" src="<?= Parameters::$BASE_URL . "assets/img/".$contenido['imagen']?>" alt="foto">
            <div class="contenido-aside2">
            <div class="nombre-aside"><?= $contenido['nombre']?></div>
            <div class="miembros-aside"><?=$membresias[$contenido['id_comunidad']]?> miembros</div>
            </div>
        </div>
        <?php }?>
    </div>

</aside>
