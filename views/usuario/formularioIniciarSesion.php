<?php

use admin\foro\Config\Parameters;
?>
<section>
    <div class="section">
        <div class="form-container">
            <h2>Iniciar Sesión</h2>
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