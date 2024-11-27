<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

$post = $data['post'] ?? NULL;
$token=$data['token'] ?? NULL;

$idUsuario = $_SESSION['user']['idUsuario'] ?? NULL;
?>
<style>
    #loading {
        text-align: center;
        padding: 20px;
        font-size: 16px;
        color: #888;
    }
</style>
<pre>
    <?php //var_dump($post);exit; 
    ?>
</pre>
<section>
    <div class="section">
        <div class="contenidoMensajes"></div>
        <?php foreach ($post as $indice => $contenido): ?>
            <div class="card-section">
                <?php
                // Determina el prefijo basado en el tipo de post
                $prefijo = ($contenido['tipo_post'] === 'normal') ? 'n/' : 'c/';

                // Determina la imagen según el tipo de post
                $imagen = ($contenido['tipo_post'] === 'normal')
                    ? Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen_logo_usuario']
                    : Parameters::$BASE_URL . 'assets/img/' . $contenido['image_comunidad']
                ?>

                <div class="encabezado-section">
                    <img src="<?= $imagen ?>" alt="imagen" class="imagenLogo-section">
                    <div class="nombre-section">
                        <?= $prefijo . $contenido['nombre']; ?>
                    </div>
                    <div class="fecha-section"><?= $contenido['fecha_creacion'] ?></div>
                    <?php if ($contenido['esta_unido'] == 0 && $contenido['tipo_post'] === "comunidad") { ?>
                        <div class="unirseBoton-section unirse"
                            data-id-comunidad="<?= $contenido['id_comunidad'] ?>"
                            data-id-usuario="<?= $idUsuario ?>">
                            Unirse
                        </div>
                    <?php } else { ?>

                    <?php } ?>
                </div>
                <div class="section-card">
                    <div class="titulo-section"><?= $contenido['titulo'] ?></div>
                    <div class="contenido-section"><?= $contenido['contenido'] ?></div>

                    <?php if (!empty($contenido['video'])): ?>
                        <!-- si existe video -->
                        <div class="videos-fotos-section">
                            <video class="video-section" controls>
                                <source src="<?= Parameters::$BASE_URL . 'assets/videos/' . $contenido['video'] ?>" type="video/mp4">
                                Tu navegador no soporta la etiqueta de video.
                            </video>
                        </div>
                    <?php elseif (!empty($contenido['imagen'])): ?>
                        <!-- si existe imagen -->
                        <div class="videos-fotos-section">
                            <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen'] ?>" alt="imagen" class="imagen-section">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="pie-section">
                    <div class="votos-seccion" id="votar"
                        data-id-post="<?= $contenido['id_post'] ?>"
                        data-id-usuario="<?= $idUsuario ?>">
                        Votos(<?= $contenido['votos'] ?>)
                    </div>
                    <div class="comentarios-section">Comentarios</div>
                    <div class="compartir-section">Compartir</div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<div id="loading"></div>

<script>
    function actualizarCamposGenericos(url, campo, idUsuario, valor) {
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    [valor]: campo,
                    idUsuario: idUsuario
                })
            })
            .then(response => response.text()) // Cambiar a .text() para ver lo que llega como respuesta
            .then(data => {
                try {
                    console.log(data);

                    let jsonData = JSON.parse(data); // Intentamos parsear la respuesta
                    document.querySelector('.contenidoMensajes').style.display = "flex";
                    // Comprobamos la respuesta completa
                    console.log("Valor de success:" + jsonData);
                    if (jsonData.success === true) {
                        let numeroVotos = document.querySelector(`#votar[data-id-post='${campo}']`);
                        if (numeroVotos) {
                            numeroVotos.innerHTML = `votos(${jsonData.votos}) `;
                        }
                        //success
                        document.querySelector('.contenidoMensajes').innerHTML = jsonData.message;
                        document.querySelector('.contenidoMensajes').classList.add("verde");
                        setTimeout(() => {
                            document.querySelector('.contenidoMensajes').classList.remove("verde");
                            document.querySelector('.contenidoMensajes').style.display = "none";
                        }, 2000);
                    } else {
                        //error
                        document.querySelector('.contenidoMensajes').innerHTML = jsonData.message;
                        document.querySelector('.contenidoMensajes').classList.add("rojo");
                        setTimeout(() => {
                            document.querySelector('.contenidoMensajes').classList.remove("rojo");
                            document.querySelector('.contenidoMensajes').style.display = "none";
                        }, 2000);

                    }
                } catch (error) {
                    alert('Error al procesar la respuesta del servidor.' + error);
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
                actualizarCamposGenericos(url, comunidad, usuario, "idComunidad"); // Llamar a la función con los valores seleccionados
            } else {
                alert('¡Algo salió mal! No se pudo procesar la solicitud.');
            }
        });
    });
    // ------------------VOTAR---------------------------------- 
    document.querySelectorAll('#votar').forEach(botonUnirse => {
        botonUnirse.addEventListener('click', function() {
            let post = botonUnirse.getAttribute('data-id-post'); // Obtener el id de la comunidad
            let usuario = botonUnirse.getAttribute('data-id-usuario'); // Obtener el id del usuario

            // Aquí puedes ajustar la URL de la solicitud si la necesitas, por ejemplo:
            const url = '<?= Parameters::$BASE_URL ?>Votos/votar';

            if (post) {
                console.log("Usuario " + usuario + " vota al post " + post);
                actualizarCamposGenericos(url, post, usuario, "idPost"); // Llamar a la función con los valores seleccionados
            } else {
                alert('¡Algo salió mal! No se pudo procesar la solicitud.');
            }
        });
    });
    let loading = false;
    let pagina = 2;


    const sectionElement = document.querySelector('section');
    sectionElement.addEventListener('scroll', function() {

        if (sectionElement.scrollTop + sectionElement.clientHeight >= sectionElement.scrollHeight - 100) {
            if (!loading) {
                loading = true;
                document.getElementById('loading').style.display = 'block'; // Mostrar el cargador
                loadMorePosts(pagina);
                pagina++;
            }
        }
    });

    // Función para cargar más posts
    function loadMorePosts(page) {

        fetch('<?= Parameters::$BASE_URL ?>Post/loadMorePosts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    pagina: page
                })
            })
            .then(response => {
                // Verificar si la respuesta tiene el formato correcto
                if (!response.ok) {
                    throw new Error('Respuesta del servidor no es exitosa. Estado: ' + response.status);
                }

                // Obtener la respuesta como texto para inspeccionarla
                return response.text(); // Usamos text en lugar de json para inspeccionar el contenido
            })
            .then(responseText => {
                try {
                    console.log('Respuesta del servidor:', responseText);
                    const data = JSON.parse(responseText);
                    if (data.success) {
                        appendPosts(data.posts);
                        loading = false; // Restablecer el estado de carga
                        document.getElementById('loading').style.display = 'none'; // Ocultar el cargador

                    } else {
                        console.warn('No se encontraron más posts');
                        loading = false; // Restablecer el estado de carga incluso si no hay más posts
                        let loadingCaja = document.getElementById('loading');
                        loadingCaja.style.display = 'block';
                        loadingCaja.innerHTML = "NO SE ENCONTRARON MAS POSTS"


                    }

                } catch (error) {
                    console.error('Error al cargar los posts:', error);

                    // Crear un mensaje detallado de error
                    let errorMessage = 'Error al procesar la solicitud del servidor.';

                    // Verificar si el error es una instancia de Error (se proporciona información adicional)
                    if (error instanceof Error) {
                        errorMessage += '\nMensaje de Error: ' + error.message;
                        errorMessage += '\nStack Trace: ' + error.stack;
                    } else {
                        // Si no es una instancia de Error (por ejemplo, el error no es un objeto de JavaScript)
                        errorMessage += '\nDetalles: ' + JSON.stringify(error, null, 2);
                    }

                    // Mostrar el error detallado en un alert
                    alert(errorMessage);
                }

            })
            .catch(error => {
                console.error('Error al cargar los posts:', error);
                loading = false; // Restablecer el estado de carga en caso de error
                document.getElementById('loading').style.display = 'none'; // Ocultar el cargador
            });
    }

    function appendPosts(posts) {
        const Parameters = {
            BASE_URL: '<?= Parameters::$BASE_URL ?>'
        };
        const container = document.querySelector('.section');
        posts.forEach(post => {
            const postElement = document.createElement('div');
            postElement.classList.add('card-section');
            postElement.innerHTML = `
    <div class="encabezado-section">
        <img src="${post.tipo_post === 'normal' ? Parameters.BASE_URL + 'assets/img/' + post.imagen_logo_usuario : Parameters.BASE_URL + 'assets/img/' + post.image_comunidad}" 
            alt="imagen" class="imagenLogo-section">
        <div class="nombre-section">
            ${post.tipo_post === 'normal' ? 'n/' : 'c/'}${post.nombre}
        </div>
        <div class="fecha-section">${post.fecha_creacion}</div>
        ${post.esta_unido === 0 && post.tipo_post === 'comunidad' ? `
            <div class="unirseBoton-section unirse"
                data-id-comunidad="${post.id_comunidad}"
                data-id-usuario="${post.id_usuario}">
                Unirse
            </div>
        ` : ''}
    </div>
    <div class="section-card">
        <div class="titulo-section">${post.titulo}</div>
        <div class="contenido-section">${post.contenido}</div>
        
        ${post.video ? `
            <div class="videos-fotos-section">
                <video class="video-section" controls>
                    <source src="${Parameters.BASE_URL}assets/videos/${post.video}" type="video/mp4">
                    Tu navegador no soporta la etiqueta de video.
                </video>
            </div>
        ` : ''}
        
        ${post.imagen ? `
            <div class="videos-fotos-section">
                <img src="${Parameters.BASE_URL}assets/img/${post.imagen}" alt="imagen" class="imagen-section">
            </div>
        ` : ''}
    </div>
    <div class="pie-section">
        <div class="votos-seccion" id="votar"
            data-id-post="${post.id_post}"
            data-id-usuario="${post.id_usuario}">
            Votos(${post.votos})
        </div>
        <div class="comentarios-section">Comentarios</div>
        <div class="compartir-section">Compartir</div>
    </div>
`;
            container.appendChild(postElement);
        });
    }
</script>