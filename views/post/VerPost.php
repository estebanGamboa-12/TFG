<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

$post = $data['post'] ?? NULL;

$idUsuario = $_SESSION['user']['idUsuario']?? NULL;
?>
<pre>
    <?php //var_dump($_SESSION['user']['idUsuario']);exit; 
    ?>
</pre>
<style>
     .contenido {
        height: 50px;
        background-color: blue;
        z-index: 1000;
        position: sticky;
        top: 0;
        width: 100%;
        justify-content: center;
        display: none;
        justify-content: center;
        align-content: flex-start;
        align-items: center;
        font-size: 1.5rem;
    }

    .verde {
        background-color: #009688;
        color: black;
    }

    .rojo {
        background-color: red;
        color: black;
    }
</style>

<section>
    <div class="section">
    <div class="contenido"></div>
        <?php foreach ($post as $indice => $contenido) {
        ?>
            <div class="card-section">
                <div class="encabezado-section">
                    <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen_logo_usuario'] ?>" alt="imagen " class="imagenLogo-section">
                    <div class="nombre-section"><?php
                                                if ($contenido['tipo_post'] === 'normal') {
                                                    echo 'n/' . $contenido['nombre'];
                                                } elseif ($contenido['tipo_post'] === 'comunidad') {
                                                    echo 'c/' . $contenido['nombre'];
                                                }
                                                ?>
                    </div>
                    <div class="fecha-section"><?= $contenido['fecha_creacion'] ?></div>
                    <?php if ($contenido['esta_unido'] == 0 && $contenido['tipo_post'] === "comunidad") { ?>
                        <div class="unirseBoton-section unirse"
                            data-id-comunidad="<?= $contenido['id_comunidad'] ?>"
                            data-id-usuario="<?= $idUsuario ?>">Unirse</div>
                    <?php } else { ?>

                    <?php } ?>
                </div>
                <div class="section-card">
                    <div class="titulo-section"><?= $contenido['titulo'] ?></div>
                    <div class="contenido-section"><?= $contenido['contenido'] ?> </div>
                    <?php if (!empty($contenido['video'])) { ?>
                        <!-- si existe video -->
                        <div class="videos-fotos-section">
                            <video class="video-section " controls>
                                <source src="<?= Parameters::$BASE_URL . 'assets/videos/' . $contenido['video'] ?>" type="video/mp4">
                                Tu navegador no soporta la etiqueta de video.
                            </video>
                        </div>
                    <?php } elseif (!empty($contenido['imagen'])) { ?>
                        <!-- si existe video -->
                        <div class="videos-fotos-section">
                            <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen'] ?>" alt="imagen" class="imagen-section">
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
<script>
    function actualizarCamposGenericos(url, idComunidad, idUsuario, valor) {
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    "idComunidad": idComunidad,
                    "idUsuario": idUsuario
                })
            })
            .then(response => response.text()) // Cambiar a .text() para ver lo que llega como respuesta
            .then(data => {
                try {

                    let jsonData = JSON.parse(data); // Intentamos parsear la respuesta
                    document.querySelector('.contenido').style.display = "flex";
                    // Comprobamos la respuesta completa
                    console.log("Valor de success:" + jsonData.success);
                    if (jsonData.success === true) {
                        let numeroMiembros = document.querySelector(`.miembrosComunidad[data-id-comunidad="${idComunidad}"]`);
                        if (numeroMiembros) {
                            numeroMiembros.innerHTML = `${jsonData.miembros} miembros`;
                        }
                        //success
                        document.querySelector('.contenido').innerHTML = jsonData.message;
                        document.querySelector('.contenido').classList.add("verde");
                        setTimeout(() => {
                            document.querySelector('.contenido').classList.remove("verde");
                            document.querySelector('.contenido').style.display = "none";
                            mensaje.remove();
                        }, 2000);
                    } else {
                        //error
                        document.querySelector('.contenido').innerHTML = jsonData.message;
                        document.querySelector('.contenido').classList.add("rojo");
                        setTimeout(() => {
                            document.querySelector('.contenido').classList.remove("rojo");
                            document.querySelector('.contenido').style.display = "none";
                        }, 2000);

                    }
                } catch (error) {
                    alert('Error al procesar la respuesta del servidor.', 'error');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud fetch:', error);
            });
    }
    // ------------------UNIRSE---------------------------------- 
    document.querySelectorAll('.unirse').forEach(botonUnirse => {
        botonUnirse.addEventListener('click', function() {
            let comunidad = botonUnirse.getAttribute('data-id-comunidad'); // Obtener el id de la comunidad
            let usuario = botonUnirse.getAttribute('data-id-usuario'); // Obtener el id del usuario

            // Aquí puedes ajustar la URL de la solicitud si la necesitas, por ejemplo:
            const url = '<?= Parameters::$BASE_URL ?>Membresias/unirseComunidad';

            if (comunidad) {
                console.log("Usuario " + usuario + " se unirá a la comunidad " + comunidad);
                actualizarCamposGenericos(url, comunidad, usuario); // Llamar a la función con los valores seleccionados
            } else {
                console.log("Usuario " + usuario + " se unirá a la comunidad " + comunidad);
                alert('¡Algo salió mal! No se pudo procesar la solicitud.');
            }
        });
    });
</script>