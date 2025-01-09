<?php

use admin\foro\Config\Parameters;
?>
<style>
    .second-aside {
        display: none;
    }
    section{
        grid-column: 2/4;
    }
    .second-aside {
        display: none;
    }
</style>
<section>
    <div class="section">
        <div class="form-container">
            <h2>Registrar Usuario</h2>
            <form action="<?= Parameters::$BASE_URL ?>Usuario/registrarUsuario" method="post" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>

                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>

                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required>

                <label for="repetir_contraseña">Repetir Contraseña:</label>
                <input type="password" id="repetir_contraseña" name="repetir_contraseña" required>

                <label for="imagen">Subir avatar:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>

                <input type="submit" value="Enviar">
            </form>
        </div>
    </div>
</section>