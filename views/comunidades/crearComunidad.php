<?php

use admin\foro\Config\Parameters;

$temas = $data['temas'] ?? NULL;

?>
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
<section>
    <div class="section">

        <div class="form-container">
            <h2>Crear comunidad</h2>
            <form action="<?= Parameters::$BASE_URL ?>Comunidades/crearComunidad" method="post" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required></textarea>

                <label for="imagen">Subir Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>

                <label for="opciones">Selecciona temas:</label>
                <select id="temas" name="temas[]" multiple required>
                    <?php foreach ($temas as $tema) : ?>
                        <option value="<?= $tema['id_temas'] ?>"><?= $tema['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Enviar">
            </form>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('#temas').select2();
    });
</script>
