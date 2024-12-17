<?php

use admin\foro\Config\Parameters;
?>
<style>
    .second-aside {
        display: none;
    }

    .textoRegistrarse {
        display: flex;
        justify-content: center;
    }
    .linkRegistrar{
        color: blue;
        border-bottom: 1px solid blue;
    }
</style>
<section>
    <div class="section">
        <div class="form-container">
            <h2>Iniciar Sesion</h2>
            <form action="<?= Parameters::$BASE_URL ?>Usuario/iniciarSesion" method="post" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required>


                <input type="submit" value="Enviar">
            </form>
            <div class="textoRegistrarse"> ¿No estás registrado en el Foro ? <a class="linkRegistrar" href="<?= Parameters::$BASE_URL ?>Usuario/mostrarFormularioRegistrar">Crea tu cuenta</a></div>
        </div>
    </div>
</section>