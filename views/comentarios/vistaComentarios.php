<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

$post = $data['post'] ?? NULL;
$token = $data['token'] ?? NULL;


$idUsuario = $_SESSION['user']['idUsuario'] ?? NULL;
?>
<pre>
    <?php //var_dump($post);exit; 
    ?>
</pre>
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
    }

    .comentario {
        margin: 20px 0;
        padding: 10px;
        background-color: #f1f1f1;
        border-radius: 10px;
    }

    .containerComentarios {
        display: flex;
        align-items: center;
    }

    .comentario-sub {
        margin: 10px 0;
        padding: 10px;
        border-radius: 10px;
        margin-left: 20px;
    }

    .subcomentarios {
        margin-top: 15px;
    }

    .contenido-comentario {
        margin: 10px 0;
    }


    .comentar-comentarios {
        margin-left: 20px;
    }

    .boton-enviar-comentario {
        border-radius: 1rem;
        padding: 5px 10px;
        display: flex;
        background-color: #00796b;
        width: 5rem;
        margin-left: auto;
        cursor: pointer;
    }
</style>
<section id="section">
    <div class="sectionAll">
        <div class="card-section" id="card-comentarios">
            <!-- Título y contenido del post -->
            <div class="conteinerEncabezado-comentarios">
                <div class="flecha-comentarios">
                    <i class="material-icons">arrow_back</i>
                </div>
                <div class="imagen-comentarios">
                    <img src="<?= Parameters::$BASE_URL ?>assets/img/1.jpg" alt="Usuario">
                </div>
                <div class="nombre-comentarios">Esteban</div>
                <div class="fecha-comentarios">13-08-2002</div>
            </div>
            <h2 class="titulo-post-comentarios">Esto es un título grandísimo</h2>
            <div class="imagen-post-comentarios">
                <img src="<?= Parameters::$BASE_URL ?>assets/img/1.jpg" alt="Usuario">
            </div>
            <div class="containerBotones-comentarios">
                <div class="votar-comentarios boton">Votar</div>
                <div class="comentar-comentarios boton">Comentar</div>
                <div class="compartir-comentarios boton">Compartir</div>
            </div>
            <div class="inputComentar">
                <input type="texto" placeholder="Comentar">
                <span class="boton-enviar-comentario">Comentar</span>
            </div>

            <!-- Lista de comentarios -->
            <div class="card-caja-comentarios">
                <div class="comentario">
                    <div class="containerComentarios">
                        <div class="imagen-comentarios">
                            <img src="<?= Parameters::$BASE_URL ?>assets/img/1.jpg" alt="Usuario">
                        </div>
                        <div class="nombre-comentarios">Esteban</div>
                        <div class="fecha-comentarios">13-08-2002</div>
                    </div>
                    <div class="contenido-comentario">Este es un comentario sobre el post.</div>
                    <div class="containerBotones-comentarios">
                        <div class="votar-comentarios boton">Votar</div>
                        <div class="comentar-comentarios boton">Comentar</div>
                    </div>

                    <!-- Subcomentarios -->
                    <div class="subcomentarios">
                        <div class="comentario-sub">
                            <div class="containerComentarios">
                                <div class="imagen-comentarios">
                                    <img src="<?= Parameters::$BASE_URL ?>assets/img/1.jpg" alt="Usuario">
                                </div>
                                <div class="nombre-comentarios">Juan</div>
                                <div class="fecha-comentarios">14-08-2002</div>
                            </div>
                            <div class="contenido-comentario">Este es un subcomentario respondiendo al comentario anterior.</div>
                        </div>

                        <div class="comentario-sub">
                            <div class="containerComentarios">
                                <div class="imagen-comentarios">
                                    <img src="<?= Parameters::$BASE_URL ?>assets/img/1.jpg" alt="Usuario">
                                </div>
                                <div class="nombre-comentarios">Ana</div>
                                <div class="fecha-comentarios">15-08-2002</div>
                            </div>
                            <div class="contenido-comentario">¡Totalmente de acuerdo con el comentario anterior!</div>
                        </div>
                    </div>
                </div>

                <!-- Otro comentario -->
                <div class="comentario">
                    <div class="containerComentarios">
                        <div class="imagen-comentarios">
                            <img src="<?= Parameters::$BASE_URL ?>assets/img/1.jpg" alt="Usuario">
                        </div>
                        <div class="nombre-comentarios">Carlos</div>
                        <div class="fecha-comentarios">16-08-2002</div>
                    </div>
                    <div class="contenido-comentario">Comentario independiente sin subcomentarios.</div>
                    <div class="containerBotones-comentarios">
                        <div class="votar-comentarios boton">Votar</div>
                        <div class="comentar-comentarios boton">Comentar</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>