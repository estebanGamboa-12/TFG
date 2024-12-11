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
                <span class="boton-enviar-comentario">Comentar</span>
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
                            <div class="respuesta-form" id="respuesta-<?= $comentario['id_comentario'] ?>" style="display:none;">
                                <input type="text" placeholder="Escribe tu respuesta...">
                                <button onclick="enviarRespuesta(<?= $comentario['id_comentario'] ?>)">Enviar</button>
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

function enviarRespuesta(idComentario) {
    console.log(idComentario);
}
 
 document.querySelector(".boton-enviar-comentario").addEventListener("click",()=>{

    let comentario=document.querySelector(".textoComentarioPrincipal").value;
    console.log(comentario);
 });
</script>