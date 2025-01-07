<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

$idUsuario = $_SESSION['user']['idUsuario'] ?? NULL;
$comunidadesRecientes = $_SESSION['comunidadesRecientes'][$idUsuario] ?? NULL;
?>
<aside class="contenido-aside first-aside">
  <div class="aside1">
    <!-- home ----------------------------------------------------------------------------------------->
    <?php if (Authentication::isUserLogged()) { ?>
      <a href="<?= Parameters::$BASE_URL ?>Post/home" class="popular">Home </a>
    <?php } ?>
    <!-- Popular ------------------------------------------------------------------->
    <?php if (Authentication::isUserLogged()) { ?>
      <a href="<?= Parameters::$BASE_URL ?>Post/popular" class="popular">Popular </a>
    <?php } else { ?>
      <a href="<?= Parameters::$BASE_URL ?>Post/popularNoLogeado" class="popular">Popular </a>
    <?php } ?>
    <!-- Explorar------------------------------------------------------------------ -->
    <?php if (Authentication::isUserLogged()) { ?>
      <a href="<?= Parameters::$BASE_URL ?>Comunidades/explorar" class="popular">Explorar </a>
    <?php } ?>
    <!-- All ---------------------------------------------------------------------------------->
    <?php if (Authentication::isUserLogged()) { ?>
      <a href="<?= Parameters::$BASE_URL ?>Post/All" class="popular">All </a>
    <?php } ?>
    <!-- recientes--------------------------------------------------------------------- -->
   
    <div class="recientes-lista contenido1">
      <?php if ($comunidadesRecientes != NULL) {?>
         <div class="recientes">
         Recientes <i class="fa fa-sort-up icono"></i>
       </div>
       <?php foreach ($comunidadesRecientes as $comunidad) {
      ?>
          <div class="logo-texto">
            <a
                            href="<?= Parameters::$BASE_URL ?>Comunidades/verComunidad?nombreComunidad=<?= $comunidad['nombre'] ?>">
                            <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $comunidad['imagen'] ?>" alt="imagen"
                                class="imagenLogo-section">
                        </a>
            <div id="textoAside1"><?= $comunidad['nombre'] ?></div>
          </div>
        <?php }
      } else { ?>
      <?php } ?>
    </div>

    <!-- Temas--------------------------------------------------------------------- -->
    <?php if ($temas != NULL) { ?>
      <div class="temas">Temas <i class="fa fa-sort-up icono"></i></div>
      <div class="temas-lista contenido1">
        <?php
        $temas_por_pagina = 6;
        $total_temas = count($temas);
        //mostrar los primeros
        foreach (array_slice($temas, 0, $temas_por_pagina) as $indice => $contenido) { ?>
          <div class="logo-texto">
            <img src="<?= Parameters::$BASE_URL . "assets/img/administrador2.png" ?>" alt="foto">
            <div id="textoAside1"><?= $contenido['nombre'] ?></div>
          </div>
        <?php } ?>
      </div>
      <button id="verMasTemas" class="ver-mas">Ver más</button>
      <button id="verMenosTemas" class="ver-menos" style="display: none;">Ver Menos</button>
    <?php } ?>

    <!-- Comunidades --------------------------------------------------------------------- -->
    <?php if ($comunidades != NULL) { ?>
      <div class="temas">Comunidades <i class="fa fa-sort-up icono"></i></div>
      <div class="crearComunidad logo-texto">
        <i class="fa fa-plus" aria-hidden="true"></i>
        <div id="textoAside1"> <a href="<?= Parameters::$BASE_URL ?>Comunidades/VistaCrearComunidad">Crear una comunidad </a></div>
      </div>
      <div class="comunidades-lista contenido1">
        <?php
        $comunidades_por_pagina = 6;
        $total_comunidades = count($comunidades);

        //muestra los primeros
        foreach (array_slice($comunidades, 0, $comunidades_por_pagina) as $indice => $contenido) { ?>
          <div class="logo-texto">
          <a
                            href="<?= Parameters::$BASE_URL ?>Comunidades/verComunidad?nombreComunidad=<?= $contenido['nombre'] ?>">
                            <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen'] ?>" alt="imagen"
                                class="imagenLogo-section">
                        </a>
            <div id="textoAside1"><?= $contenido['nombre'] ?></div>
          </div>
        <?php } ?>
      </div>
      <button id="verMasComunidades" class="ver-mas">Ver más</button>
      <button id="verMenosComunidades" class="ver-menos" style="display: none;">Ver Menos</button>
    <?php } else { ?>
      <div class="temas">Comunidades <i class="fa fa-sort-up icono"></i></div>
      <div class="crearComunidad logo-texto">
        <i class="fa fa-plus" aria-hidden="true"></i>
        <div id="textoAside1"> <a href="<?= Parameters::$BASE_URL ?>Comunidades/VistaCrearComunidad">Crear una comunidad </a></div>
      </div>
    <?php } ?>
  </div>
</aside>
<style>
  .icono-flecha, .icono-punto, .icono-linea {
    display: inline-block;
    margin-left: 5px; /* Espacio entre el texto y el ícono */
    font-size: 20px; /* Tamaño del ícono */
    color: #000; /* Color del ícono */
}
</style>
<script>
  // Inicialización de variables
  let temasMostrados = 6;
  let comunidadesMostradas = 6;
  let temasPorPagina = 6;
  let comunidadesPorPagina = 6;
  <?php $comunidades = $comunidades ?? []; ?>
  let totalTemas = <?= json_encode(count($temas)); ?>; // Total de temas disponibles
  let totalComunidades = <?= json_encode(count($comunidades)); ?>; // Total de comunidades disponibles

  let temas = <?= json_encode($temas); ?>; // Todos los temas disponibles
  let comunidades = <?= json_encode($comunidades); ?>; // Todas las comunidades disponibles

  // Función para cargar los temas
  function cargarTemas() {
    // Obtener los temas que se mostrarán según temasMostrados
    let temasParaMostrar = temas.slice(0, temasMostrados);

    // Crear el HTML para los temas que se van a mostrar
    let contenidoHTML = '';
    temasParaMostrar.forEach(function(tema) {
      contenidoHTML += `
      <div class="logo-texto">
            <div id="textoAside1">${tema.nombre}</div>
            <a class="icono-flecha" href="<?= Parameters::$BASE_URL?>Temas/verTemas?nombreTema=${tema.nombre}">➔</a>
        </div>
      `;
    });

    // Insertar el HTML generado en el contenedor de temas
    document.querySelector(".temas-lista").innerHTML = contenidoHTML;

    // Mostrar u ocultar los botones según los temas mostrados
    if (temasMostrados >= totalTemas) {
      // Si ya se han mostrado todos los temas, ocultar "Ver más"
      document.getElementById("verMasTemas").style.display = 'none';
    } else {
      // Si no todos los temas se han mostrado, mostrar "Ver más"
      document.getElementById("verMasTemas").style.display = 'block';
    }

    // Mostrar el botón "Ver menos" solo si hemos mostrado más de 6 temas
    if (temasMostrados > 6) {
      document.getElementById("verMenosTemas").style.display = 'block';
    } else {
      document.getElementById("verMenosTemas").style.display = 'none';
    }
  }

  // Función para cargar las comunidades
  function cargarComunidades() {

    // Obtener las comunidades que se mostrarán según comunidadesMostradas
    let comunidadesParaMostrar = comunidades.slice(0, comunidadesMostradas);

    // Crear el HTML para las comunidades que se van a mostrar
    let contenidoHTML = '';
    comunidadesParaMostrar.forEach(function(comunidad) {
      contenidoHTML += `
        <div class="logo-texto">
          <img src="<?= Parameters::$BASE_URL ?>assets/img/${comunidad.imagen}" alt="foto">
          <div id="textoAside1">${comunidad.nombre}</div>
        </div>
      `;
    });

    // Insertar el HTML generado en el contenedor de comunidades
    document.querySelector(".comunidades-lista").innerHTML = contenidoHTML;

    // Mostrar u ocultar los botones según las comunidades mostradas
    if (comunidadesMostradas >= totalComunidades) {
      // Si ya se han mostrado todas las comunidades, ocultar "Ver más"
      document.getElementById("verMasComunidades").style.display = 'none';
    } else {
      // Si no todas las comunidades se han mostrado, mostrar "Ver más"
      document.getElementById("verMasComunidades").style.display = 'block';
    }

    // Mostrar el botón "Ver menos" solo si hemos mostrado más de 6 comunidades
    if (comunidadesMostradas > 6) {
      document.getElementById("verMenosComunidades").style.display = 'block';
    } else {
      document.getElementById("verMenosComunidades").style.display = 'none';
    }
  }

  // Función general para manejar los "Ver más" y "Ver menos"
  function manejarContenido(tipo, mostrarMas) {
    if (tipo === 'temas') {
      // Si es para los temas, modificar el valor de temasMostrados
      if (mostrarMas) {
        temasMostrados = totalTemas; // Mostrar todos los temas
      } else {
        temasMostrados = 6; // Volver a los primeros 6 temas
      }
      cargarTemas(); // Actualizar la vista de los temas
    } else if (tipo === 'comunidades') {
      // Si es para las comunidades, modificar el valor de comunidadesMostrados
      if (mostrarMas) {
        comunidadesMostradas = totalComunidades; // Mostrar todas las comunidades
      } else {
        comunidadesMostradas = 6; // Volver a las primeras 6 comunidades
      }
      cargarComunidades(); // Actualizar la vista de las comunidades
    }
  }

  // Inicializar la vista con los primeros 6 temas y comunidades
  cargarTemas();
  cargarComunidades();

  // Evento para el botón "Ver más" de temas
  document.getElementById("verMasTemas").addEventListener("click", function() {
    manejarContenido('temas', true); // Mostrar todos los temas
  });

  // Evento para el botón "Ver menos" de temas
  document.getElementById("verMenosTemas").addEventListener("click", function() {
    manejarContenido('temas', false); // Volver a los primeros 6 temas
  });

  // Evento para el botón "Ver más" de comunidades
  document.getElementById("verMasComunidades").addEventListener("click", function() {
    manejarContenido('comunidades', true); // Mostrar todas las comunidades
  });

  // Evento para el botón "Ver menos" de comunidades
  document.getElementById("verMenosComunidades").addEventListener("click", function() {
    manejarContenido('comunidades', false); // Volver a las primeras 6 comunidades
  });
  //-----------------------------------------------------------------------------------------------------------------------------------------------

  // Seleccionamos todos los íconos de la flecha, los contenedores de contenido y los botones de ver más/menos
  const flechaIconos = document.querySelectorAll('.icono');
  const contenidos = document.querySelectorAll('.contenido1');
  const verMasButtons = document.querySelectorAll('.ver-mas');
  //console.log(verMasButtons);

  // Recorremos cada uno de los íconos de la flecha
  flechaIconos.forEach((flechaIcono, index) => {
    flechaIcono.addEventListener('click', function() {
      contenidos[index].classList.toggle('oculto');

      flechaIcono.classList.toggle('rotado');

      if (contenidos[index].classList.contains('oculto')) {
        index = index;
        console.log(index);
        verMasButtons[index].style.display = 'none ';
      } else {
        index = index;
        console.log(index);
        verMasButtons[index].style.display = 'block';
      }
    });
  });
</script>