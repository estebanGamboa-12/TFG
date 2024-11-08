<?php 
use admin\foro\Config\Parameters;
?>


        <aside class="contenido-aside first-aside">
            <div class="aside1">
                <div class="popular">Popular <i class="fa fa-sort-down"></i></div>
                <div class="recientes">Recientes <i class="fa fa-sort-down"></i></div>
                <div class="logo-texto">
                    <img src=" <?= Parameters::$BASE_URL . "assets/img/administrador2.png" ?>" alt="foto">
                    <div id="textoAside1">esteban</div>
                </div>
                <div class="logo-texto">
                    <img src="<?= Parameters::$BASE_URL . "assets/img/administrador.png" ?>" alt="foto">
                    <div id="textoAside1">123</div>
                </div>
                <div class="temas">Temas <i class="fa fa-sort-down"></i></div>
                <?php
                 foreach($datos['temas'] as $indice=>$contenido){ ?>
                <div class="logo-texto">
                    <img src="<?= Parameters::$BASE_URL . "assets/img/administrador2.png" ?>" alt="foto">
                    <div id="textoAside1"><?= $contenido['nombre_tema']?></div>
                </div>
                <?php }?>
                
                <div class="logo-texto comunidades">
                    <img src=" <?= Parameters::$BASE_URL ."assets/img/administrador3.png"?>" alt="foto">
                    <div id="textoAside1">Comunidades</div>
                </div>
            </div>
        </aside>
    
       
       
    
 
    


