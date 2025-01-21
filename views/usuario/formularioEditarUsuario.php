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
$datosUsuario=$data['datosUsuario'];
?>
<section>
    <div class="section">
        <div class="form-container">
            <h2>Editar Usuario</h2>
            <form action="<?= Parameters::$BASE_URL ?>Usuario/editarUsuario" method="post" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?= $datosUsuario['nombre']?>" >

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?= $datosUsuario['apellido']?>" >

                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" value="<?= $datosUsuario['correo']?>" >

                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" >

                <label for="repetir_contraseña">Repetir Contraseña:</label>
                <input type="password" id="repetir_contraseña" name="repetir_contraseña" >

                <label for="imagen">Subir avatar:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" >

                <input type="submit" value="Enviar">
            </form>
        </div>
    </div>
</section>