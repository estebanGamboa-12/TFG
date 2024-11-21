<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

?>
<style>
  a {
    text-decoration: none;
  }
</style>


<aside class="contenido-aside first-aside">
  <div class="aside1">
    <!-- home ----------------------------------------------------------------------------------------->
    <?php if (Authentication::isUserLogged()) { ?>
      <a href="<?= Parameters::$BASE_URL ?>Post/home" class="popular">Home <i class="fa fa-sort-down"></i></a>
    <?php } ?>
    <!-- Popular ------------------------------------------------------------------->
    <?php if (Authentication::isUserLogged()) { ?>
      <a href="<?= Parameters::$BASE_URL ?>Post/popular" class="popular">Popular <i class="fa fa-sort-down"></i></a>
    <?php }else{ ?>
    <a href="<?= Parameters::$BASE_URL ?>Post/popularNoLogeado" class="popular">Popular <i class="fa fa-sort-down"></i></a>
    <?php } ?>
    <!-- Explorar------------------------------------------------------------------ -->
    <?php if (Authentication::isUserLogged()) { ?>
      <a href="<?= Parameters::$BASE_URL ?>Comunidades/explorar" class="popular">Explorar <i class="fa fa-sort-down"></i></a>
    <?php } ?>
    <!-- All ---------------------------------------------------------------------------------->
    <?php if (Authentication::isUserLogged()) { ?>
      <a href="<?= Parameters::$BASE_URL ?>Post/All" class="popular">All <i class="fa fa-sort-down"></i></a>
    <?php } ?>
    <!-- Recientes ------------------------------------------------------------------------------------>
    <div class="recientes">Recientes <i class="fa fa-sort-down"></i></div>
    <div class="logo-texto">
      <img src=" <?= Parameters::$BASE_URL . "assets/img/administrador2.png" ?>" alt="foto">
      <div id="textoAside1">esteban</div>
    </div>
    <div class="logo-texto">
      <img src="<?= Parameters::$BASE_URL . "assets/img/administrador.png" ?>" alt="foto">
      <div id="textoAside1">123</div>
    </div>
    <!-- Temas --------------------------------------------------------------------------------->
    <div class="temas">Temas <i class="fa fa-sort-down"></i></div>
    <?php
    foreach ($temas as $indice => $contenido) { ?>
      <div class="logo-texto">
        <img src="<?= Parameters::$BASE_URL . "assets/img/administrador2.png" ?>" alt="foto">
        <div id="textoAside1"><?= $contenido['nombre'] ?></div>
      </div>
    <?php } ?>

    <div class="logo-texto comunidades">
      <img src=" <?= Parameters::$BASE_URL . "assets/img/administrador3.png" ?>" alt="foto">
      <div id="textoAside1">Comunidades</div>
    </div>
  </div>
</aside>