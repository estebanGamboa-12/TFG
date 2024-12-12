<?php

use admin\foro\Config\Parameters;

$temas = $data['temas'] ?? NULL;

?>
<section>
    <div class="section">

        <div class="form-container">
            <h2>Formulario</h2>
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
<style>
    option.selected {
        background-color: #007BFF;
        color: white;
    }

    select {
        width: 95%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        background-color: #fff;
        color: #555;
        cursor: pointer;
    }

    select:focus {
        border-color: #4CAF50;
        /* Cambia el color del borde al enfocar */
        outline: none;
        /* Elimina el contorno predeterminado */
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        /* Agrega una sombra al enfocar */
    }

    .form-container {
        display: flex;
        flex-direction: column;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 95%;
        padding: 3% 1%;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
    }

    input[type="text"],
    textarea,
    input[type="file"] {
        width: 95%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    textarea {
        resize: none;
        height: 100px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>