<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

$post = $data['post'] ?? NULL;
$comentarios = $data['comentarios'] ?? NULL;
$token = $data['token'] ?? NULL;


$idUsuario = $_SESSION['user']['idUsuario'] ?? NULL;
?>

<style>
    #card-comentarios {
        display: flex;
        flex-direction: column;
        margin: 20px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
    }

    .conteinerEncabezado-comentarios {
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-bottom: 20px;
    }

    .flecha-comentarios,
    .imagen-comentarios img {
        height: 2rem;
        width: 2rem;
        border-radius: 1rem;
    }

    .nombre-comentarios,
    .fecha-comentarios {
        margin-left: 10px;
    }

    .titulo-post-comentarios {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .imagen-post-comentarios img {
        width: 100%;
        height: auto;
        margin-top: 2%;
        margin-bottom: 2%;
        border-radius: 10px;
    }

    .containerBotones-comentarios {
        display: flex;
        flex-direction: row;
        margin-bottom: 10px;
    }

    .boton {
        background-color: #009688;
        padding: 5px 10px;
        border-radius: 1rem;
        margin-right: 10px;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .inputComentar input {
        width: 100%;
        border-radius: 1rem;
        margin: 2% 0%;
        height: 2rem;
        padding: 0 10px;
    }

    .card-caja-comentarios {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .comentario {
        margin: 20px 0;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .containerComentarios {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        flex-direction: column;
    }

    .comentario-sub {
        margin: 10px 0;
        padding: 15px;
        border-radius: 10px;
        margin-left: 40px;
        box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
        width: 80%;
    }

    .subcomentarios {
        margin-top: 15px;
        padding-left: 20px;
        border-left: 2px solid #e0e0e0;
    }

    .contenido-comentario {
        margin: 10px 0;
        font-size: 0.95rem;
        color: #333;
    }

    .comentar-comentarios {
        margin-left: 20px;
        font-size: 0.85rem;
        color: #555;
        cursor: pointer;
    }

    .boton-enviar-comentario {
        border-radius: 1rem;
        padding: 5px 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #00796b;
        color: white;
        font-size: 0.9rem;
        font-weight: bold;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 6rem;
        margin-left: auto;
    }

    .boton-enviar-comentario:hover {
        background-color: #005b54;
    }

    /* Nuevos estilos opcionales */
    .nombre-comentario {
        font-weight: bold;
        font-size: 1rem;
        color: #00796b;
    }

    .fecha-comentario {
        font-size: 0.85rem;
        color: #999;
    }

    .imagen-comentarios img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .contenedorComentarioNombre {
        display: flex;
    }

    .comentarios {
        width: 100%;
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 3%;
    }

    .subcomentarios .comentario-sub {
        margin-left: calc(var(--nivel) * 20px);
        /* Ejemplo: Desplazar según el nivel */
    }
</style>
<pre>
    <?php
    // var_dump($comentarios['subcomentarios']);
    ?>
</pre>
<section id="section">
    <div class="sectionAll">
        <div class="card-section" id="card-comentarios">
            <!-- Título y contenido del post -->
            <div class="conteinerEncabezado-comentarios">
                <div class="flecha-comentarios back" onclick="goBack()">
                    <i class="material-icons">arrow_back</i>
                </div>
                <?php if ($post['tipo_post'] == "normal") { ?>
                    <div class="imagen-comentarios">
                        <img src="<?= Parameters::$BASE_URL ?>assets/img/<?= $post['imagen_logo_usuario'] ?>" alt="Usuario">
                    </div>
                    <div class="nombre-comentarios"><?= $post['nombre_usuario'] ?></div>
                <?php } else { ?>
                    <div class="imagen-comentarios">
                        <img src="<?= Parameters::$BASE_URL ?>assets/img/<?= $post['imagen_comunidad'] ?>" alt="Usuario">
                    </div>
                    <div class="nombre-comentarios"><?= $post['nombre_comunidad'] ?></div>
                <?php } ?>
                <div class="fecha-comentarios"><?= $post['fecha_creacion'] ?></div>
            </div>
            <h2 class="titulo-post-comentarios"><?= $post['titulo'] ?></h2>
            <div class="nombre-comentarios"><?= $post['contenido'] ?></div>
            <div class="imagen-post-comentarios">
                <img src="<?= Parameters::$BASE_URL ?>assets/img/1.jpg" alt="imagen">
            </div>
            <div class="containerBotones-comentarios">
                <div class="votar-comentarios boton votar">Votos (<?= $post['votos_totales'] ?>)</div>
                <div class="compartir-comentarios boton">Compartir</div>
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
                                <div class="nombre-comentarios"><?= htmlspecialchars($comentario['nombre_usuario_comentario'] ?? 'Usuario desconocido') ?></div>
                                <div class="fecha-comentarios"><?= htmlspecialchars($comentario['fecha_creacion'] ?? 'Fecha no disponible') ?></div>
                            </div>
                            <div class="contenido-comentario"><?= htmlspecialchars($comentario['contenido'] ?? 'Sin contenido') ?></div>
                            <div class="containerBotones-comentarios">
                                <div class="comentar-comentarios boton" onclick="mostrarFormularioRespuesta(<?= $comentario['id_comentario'] ?>)">Comentar</div>
                            </div>
                             <div class="respuesta-form" id="respuesta-<?= $comentario['id_comentario'] ?>" style="display:none;">
                                <input type="text" placeholder="Escribe tu respuesta...">
                                <button onclick="enviarRespuesta(<?= $comentario['id_comentario'] ?>,<?= $post['id_post'] ?>)">Enviar</button>
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
                                                <div class="nombre-comentarios"><?= htmlspecialchars($subcomentario['nombre_usuario_subcomentario']) ?></div>
                                                <div class="fecha-comentarios"><?= $subcomentario['subcomentario_fecha'] ?></div>
                                            </div>
                                            <div class="contenido-comentario"><?= htmlspecialchars($subcomentario['subcomentario_contenido']) ?></div>
                                            <div class="containerBotones-comentarios">
                                                <div class="comentar-comentarios boton">Comentar</div>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                           
                        </div>
                    <?php }
                } else { ?>
                    <p>No hay comentarios disponibles para este post.</p>
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

    function enviarRespuesta(idComentario,idPost) {
    const input = document.querySelector(`#respuesta-${idComentario} input`);
    const subComentario   = input.value;

    const parametersBaseUrl = "http://localhost/proyectos/TFG/";
    let url = parametersBaseUrl + "Comentarios/subirComentario";

    fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                comentario: subComentario ,
                idComentario: idComentario,
                idPost:idPost,
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
                subcomentariosContainer.appendChild(nuevoSubComentario);

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

        const parametersBaseUrl = "http://localhost/proyectos/TFG/";
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
                    if(JSONdata.success){
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
                    <div class="subcomentarios"></div>
                    <div class="respuesta-form" id="respuesta-${JSONdata.comentario.id_comentario}" style="display:none;">
                    <input type="text" placeholder="Escribe tu respuesta...">
                    <button onclick="enviarRespuesta(${JSONdata.comentario.id_comentario},${JSONdata.comentario.id_post})">Enviar</button>
                    </div>
                    `;
                          // Insertar el nuevo comentario al principio de la lista de comentarios
                          const containerComentarios = document.querySelector('.containerComentarios');
                    containerComentarios.insertBefore(nuevoComentario, containerComentarios.firstChild);

                    // Limpiar el campo de texto del comentario
                    document.querySelector(".textoComentarioPrincipal").value = '';

                    }else{
                        alert(JSONdata.mensaje);
                    }

              


                } catch (error) {
                    alert('Error al procesar la respuesta del servidor.' + error);
                }
            })
            .catch(error => {
                console.error('Error en la solicitud fetch:', error);
            });
    });
</script>