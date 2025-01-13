<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

$post = $data['post'] ?? NULL;
$comentarios = $data['comentarios'] ?? NULL;
$token = $data['token'] ?? NULL;


$idUsuario = $_SESSION['user']['idUsuario'] ?? NULL;
?>
<style>
    .margin{
        margin: 2% 0%;
    }
</style>

<pre>
    <?php
    // var_dump($post);exit;
    ?>
</pre>
<?php
if (!empty($_SESSION['errores'])) {
    echo '<div class="error-container">';
    echo '<div class="error-messages">';
    echo '<ul>';
    foreach ($_SESSION['errores'] as $error) {
        echo "<li>$error</li>";
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    unset($_SESSION['errores']);
}
?>
<section id="section">
    <div class="sectionAll">
        <div class="contenidoMensajes"></div>
        <div class="card-section" id="card-comentarios">
            <!-- Título y contenido del post -->
            <div class="conteinerEncabezado-comentarios">
                <div class="flecha-comentarios back" onclick="goBack()">
                    <i class="material-icons">arrow_back</i>
                </div>
                <?php if ($post['tipo_post'] == "normal") { ?>
                    <div class="imagen-comentarios">
                        <a href="<?= Parameters::$BASE_URL ?>Usuario/verUsuario?nombre=<?= $post['nombre_usuario'] ?>">
                            <img src="<?= Parameters::$BASE_URL ?>assets/img/<?= $post['imagen_logo_usuario'] ?>" alt="Usuario">
                        </a>
                    </div>
                    <div class="nombre-comentarios"><?= $post['nombre_usuario'] ?></div>
                <?php } else { ?>
                    <div class="imagen-comentarios">
                        <a href="<?= Parameters::$BASE_URL ?>Comunidades/verComunidad?nombreComunidad=<?= $post['nombre_comunidad'] ?>">
                            <img src="<?= Parameters::$BASE_URL ?>assets/img/<?= $post['imagen_comunidad'] ?>" alt="Usuario">
                        </a>
                    </div>
                    <div class="nombre-comentarios"><?= $post['nombre_comunidad'] ?></div>
                <?php } ?>
                <div class="fecha-comentarios"><?= $post['fecha_creacion'] ?></div>
            </div>
            <h2 class="titulo-post-comentarios"><?= $post['titulo'] ?></h2>
            <?php
            $contenido_texto = trim($post['contenido']); // Elimina los espacios alrededor del texto
            if ($post['video'] == NULL && $post['imagen'] == NULL) {
                if (strpos($contenido_texto, 'http') !== false) { ?>
                    <a  href="#" class="link margin" style="color: blue; "><?= $contenido_texto ?></a>
                <?php } else { ?>
                    <div class="margin"> <?= $contenido_texto ?></div>
            <?php }
            } else{?>
            <div class="imagen-post-comentarios">
                <?php if ($post['video'] != NULL) { ?>
                    <video style="width: 100%; margin:2% 0%" src="<?= Parameters::$BASE_URL ?>assets/videos/<?= $post['video'] ?>" controls autoplay></video>
                <?php } else { ?>
                    <img  style="width: 100%; margin-top: 2%;" src="<?= Parameters::$BASE_URL ?>assets/img/<?= $post['imagen'] ?>" alt="imagen">
                <?php } ?>
            </div>
            <?php } ?>
            <div class="containerBotones-comentarios">
                <div class="votos-seccion boton  votar"
                    data-token-votar="<?= $token ?>">
                    Votos(<?= $post['votos_totales'] ?>)
                </div>
            </div>
            <div class="inputComentar">
                <input type="texto" class="textoComentarioPrincipal" placeholder="Comentar">
                <span class="boton-enviar-comentario" data-id-post="<?= $post['id_post'] ?>">Comentar</span>
            </div>
            <!-- Lista de comentarios -->
            <div class="containerComentarios">
                <?php
                if (isset($comentarios['comentarios']) && count($comentarios['comentarios']) > 0) {
                    foreach ($comentarios['comentarios'] as $comentario) { ?>
                        <div class="comentarios">
                            <div class="imagen-comentarios">
                                <img src="<?= Parameters::$BASE_URL ?>assets/img/1.jpg" alt="Usuario">
                            </div>
                            <div class="contenedorComentarioNombre">
                                <div class="nombre-comentarios">
                                    <?= htmlspecialchars($comentario['nombre_usuario_comentario'] ?? 'Usuario desconocido') ?>
                                </div>
                                <div class="fecha-comentarios">
                                    <?= htmlspecialchars($comentario['fecha_creacion'] ?? 'Fecha no disponible') ?></div>
                            </div>
                            <div class="contenido-comentario">
                                <?= htmlspecialchars($comentario['contenido'] ?? 'Sin contenido') ?></div>
                            <div class="containerBotones-comentarios">
                                <div class="comentar-comentarios boton"
                                    onclick="mostrarFormularioRespuesta(<?= $comentario['id_comentario'] ?>)">Comentar</div>
                            </div>
                            <div class="respuesta-form" id="respuesta-<?= $comentario['id_comentario'] ?>"
                                style="display:none;">
                                <input type="text" class="textoComentarioPrincipal" placeholder="Escribe tu respuesta">
                                <button class="boton"
                                    onclick="enviarRespuesta(<?= $comentario['id_comentario'] ?>,<?= $post['id_post'] ?>)">Enviar</button>
                            </div>
                            <div class="subcomentarios">
                                <?php
                                // Mostrar subcomentarios
                                foreach ($comentarios['subcomentarios'] as $subcomentario) {
                                    if ($subcomentario['subcomentario_padre'] == $comentario['id_comentario']) { ?>
                                        <div class="comentario-sub">
                                            <div class="containerComentarios">
                                                <div class="imagen-comentarios">
                                                    <img src="<?= Parameters::$BASE_URL ?>assets/img/1.jpg" alt="Usuario">
                                                </div>
                                                <div class="nombre-comentarios">
                                                    <?= htmlspecialchars($subcomentario['nombre_usuario_subcomentario']) ?></div>
                                                <div class="fecha-comentarios"><?= $subcomentario['subcomentario_fecha'] ?></div>
                                            </div>
                                            <div class="contenido-comentario">
                                                <?= htmlspecialchars($subcomentario['subcomentario_contenido']) ?></div>
                                            <div class="containerBotones-comentarios">
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <p class="noComentarios">No hay comentarios disponibles para este post.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<script>
    function goBack() {
        window.history.back();
    }

    function mostrarFormularioRespuesta(idComentario) {
        const form = document.getElementById('respuesta-' + idComentario);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function enviarRespuesta(idComentario, idPost) {
        const input = document.querySelector(`#respuesta-${idComentario} input`);
        const subComentario = input.value;

        const parametersBaseUrl = "http://localhost/TFG/";
        let url = parametersBaseUrl + "Comentarios/subirComentario";

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    comentario: subComentario,
                    idComentario: idComentario,
                    idPost: idPost,
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Respuesta del servidor no es exitosa. Estado: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                if (data.success) {
                    // Crear un nuevo elemento para el subcomentario
                    const nuevoSubComentario = document.createElement('div');
                    nuevoSubComentario.classList.add('comentario-sub');
                    nuevoSubComentario.innerHTML = `
                    <div class="containerComentarios">
                        <div class="imagen-comentarios">
                            <img src="${parametersBaseUrl}assets/img/1.jpg" alt="Usuario">
                        </div>
                        <div class="nombre-comentarios">${data.comentario.nombre}</div>
                        <div class="fecha-comentarios">${data.comentario.fecha_creacion}</div>
                    </div>
                    <div class="contenido-comentario">${data.comentario.contenido}</div>
                `;
                    // Insertar el nuevo subcomentario en el contenedor correspondiente
                    const subcomentariosContainer = document.querySelector(`.subcomentarios`);
                    subcomentariosContainer.insertBefore(nuevoSubComentario, subcomentariosContainer.firstChild);

                    // Limpiar el campo de texto del subcomentario
                    input.value = '';
                } else {
                    alert(data.mensaje);
                }
            })
            .catch(error => {
                console.error('Error en la solicitud fetch:', error);
            });
    }

    document.querySelector(".boton-enviar-comentario").addEventListener("click", () => {

        const parametersBaseUrl = "http://localhost/TFG/";
        let comentario = document.querySelector(".textoComentarioPrincipal").value;
        let url = parametersBaseUrl + "Comentarios/subirComentario";
        let idPost = document.querySelector(".boton-enviar-comentario").getAttribute("data-id-post");
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    comentario: comentario,
                    idPost: idPost,
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
            .then(data => {
                try {
                    let JSONdata = JSON.parse(data);
                    console.log(JSONdata.comentario);
                    if (JSONdata.success) {
                        // Crear un nuevo elemento para el comentario
                        const nuevoComentario = document.createElement('div');
                        nuevoComentario.classList.add('comentarios');
                        nuevoComentario.innerHTML = `
                    <div class="imagen-comentarios">
                    <img src="${parametersBaseUrl}assets/img/1.jpg" alt="Usuario">
                    </div>
                    <div class="contenedorComentarioNombre">
                    <div class="nombre-comentarios">${JSONdata.comentario.nombre}</div>
                    <div class="fecha-comentarios">${JSONdata.comentario.fecha_creacion}</div>
                    </div>
                    <div class="contenido-comentario">${JSONdata.comentario.contenido}</div>
                    <div class="containerBotones-comentarios">
                    <div class="comentar-comentarios boton" onclick="mostrarFormularioRespuesta(${JSONdata.comentario.id_comentario})">Comentar</div>
                    </div>
                    <div class="respuesta-form" id="respuesta-${JSONdata.comentario.id_comentario}" style="display:none;">
                    <input class="textoComentarioPrincipal" type="text" placeholder="Escribe tu respuesta">
                    <button class="boton" onclick="enviarRespuesta(${JSONdata.comentario.id_comentario},${JSONdata.comentario.id_post})">Enviar</button>
                    </div>
                    <div class="subcomentarios"></div>
                    `;
                        // Insertar el nuevo comentario al principio de la lista de comentarios
                        const containerComentarios = document.querySelector('.containerComentarios');
                        containerComentarios.insertBefore(nuevoComentario, containerComentarios.firstChild);

                        // Limpiar el campo de texto del comentario
                        document.querySelector(".textoComentarioPrincipal").value = '';
                        let mensajeNoComentarios = document.querySelector(".noComentarios");
                        if (mensajeNoComentarios) {
                            mensajeNoComentarios.textContent = "";
                        }

                    } else {
                        alert(JSONdata.mensaje);
                    }

                } catch (error) {
                    console.error('Error al procesar la respuesta del servidor:', error);
                    alert('Error al procesar la respuesta del servidor.' + error);
                }
            })
            .catch(error => {
                console.error('Error en la solicitud fetch:', error);
            });
    });
</script>