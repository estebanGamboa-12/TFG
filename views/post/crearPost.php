<?php

use admin\foro\Config\Parameters;

$comunidades = $data['comunidades'] ?? NULL;

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
            <h2>Formulario</h2>
            <form id="dynamicForm" action="<?= Parameters::$BASE_URL ?>Post/subirPost" method="post"
                enctype="multipart/form-data">
                <label for="comunidad">Selecciona Comunidad:</label>
                <select id="comunidad" name="comunidad" required>
                    <optgroup label="Usuario ">
                        <option value="<?= $_SESSION['user']['idUsuario'] ?>">
                            <?= $_SESSION['user']['nombre'] ?>
                        </option>
                    </optgroup>
                    <optgroup label="Comunidades">
                        <?php foreach ($comunidades as $comunidad): ?>
                            <option value="<?= $comunidad['id_comunidad']; ?>">
                                <img src="<?= $comunidad['imagen']; ?>" alt="<?= $comunidad['nombre']; ?>"
                                    style="inline-size: 20px; block-size: 20px; vertical-align: middle;">
                                <?= $comunidad['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
                <label for="tema" style="display: none;">Selecciona un tema :</label>
                <select id="tema" name="idTema" style="display: none;">
                    <!-- Las opciones se llenarán dinámicamente -->
                </select>

                <div class="button-group">
                    <button type="button" class="btn-option" data-option="text">Texto</button>
                    <button type="button" class="btn-option" data-option="media">Imagen/Video</button>
                    <button type="button" class="btn-option" data-option="link">Otro Link</button>
                </div>

                <div id="formContent">
                    <label for="titulo_texto">Título:</label>
                    <input type="text" id="titulo_texto" name="titulo" required>
                    <label for="contenido_texto">Contenido:</label>
                    <textarea id="contenido_texto" name="contenido" required></textarea>
                </div>

                <input type="submit" value="Enviar">
            </form>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        // Inicializar select2 si es necesario
        $('#comunidad').select2();

        // Manejar el cambio de contenido del formulario
        $('.btn-option').on('click', function () {
            const option = $(this).data('option');
            let content = '';

            if (option === 'text') {
                content = `
                    <label for="titulo_texto">Título:</label>
                    <input type="text" id="titulo_texto" name="titulo" required>
                    <label for="contenido_texto">Contenido:</label>
                    <textarea id="contenido_texto" name="contenido" required></textarea>
                `;
            } else if (option === 'media') {
                content = `
                    <label for="titulo_media">Título:</label>
                    <input type="text" id="titulo_media" name="titulo" required>
                    <label for="contenido_texto">Contenido:</label>
                    <textarea id="contenido_texto" name="contenido" required></textarea>
                    <label for="archivo_media">Subir Imagen/Video:</label>
                    <input type="file" id="archivo_media" name="archivo" accept="image/*,video/*" required>
                     
                `;
            } else if (option === 'link') {
                content = `
                    <label for="titulo_link">Título:</label>
                    <input type="text" id="titulo_link" name="titulo" required>
                    <label for="url_link">URL:</label>
                    <input type="url" id="url_link" name="contenido" required placeholder="ej: foro.com">
                    <span id="url_error" style="color: red;"></span>
                    
                `;
            }

            $('#formContent').html(content);

            const validTLDs = [
                'com', 'org', 'net', 'edu', 'gov', 'mil', 'co', 'io', 'ai', 'es', 'mx', 'cl', 'info', 'biz', 'dev', 'xyz'
            ];
            const tldRegex = new RegExp(`\\.(${validTLDs.join('|')})$`, 'i');

            // Agregar evento para el campo de URL
            $('#url_link').on('input', function () {
                let value = $(this).val().trim();
                const errorMessage = $('#url_error');

                if (value && !value.startsWith('http://') && !value.startsWith('https://')) {
                    if (tldRegex.test(value)) {
                        $(this).val('http://' + value);
                        $(this).css('border', ''); // Quitar borde rojo
                        errorMessage.text(''); // Limpiar mensaje de error
                    } else {
                        // Mostrar error si el dominio no es válido
                        $(this).css('border', '1px solid red');
                        errorMessage.text('URL no válida.');
                    }
                } else if (!value) {
                    // Reiniciar estilos si el campo está vacío
                    $(this).css('border', '');
                    errorMessage.text('');
                }
            });

            // Manejar el envío del formulario para impedir enviar datos no válidos
            $('#form').on('submit', function (e) {
                const value = $('#url_link').val().trim();
                const errorMessage = $('#url_error');

                if (option === 'link' && (!tldRegex.test(value) || (!value.startsWith('http://') && !value.startsWith('https://')))) {
                    e.preventDefault(); // Evita el envío del formulario
                    $('#url_link').css('border', '2px solid red'); // Resaltar el campo con borde rojo
                    errorMessage.text('No puedes enviar un enlace no válido.').css('color', 'red');
                }
            });
        });

        // Inicializar el contenido por defecto como "Texto"
        $('.btn-option[data-option="text"]').click();

        $('#comunidad').change(function () {
            let idComunidad = $(this).val();

            $('#tema').empty().hide();
            $('label[for="tema"]').hide();

            if (idComunidad) {
                $.ajax({

                    type: 'GET',
                    url: '<?= Parameters::$BASE_URL ?>Temas/obtenerTemas',
                    data: {
                        idComunidad: idComunidad
                    },
                    success: function (data) {
                        let JSONdata = JSON.parse(data);
                        if (JSONdata.temas.length > 0) {
                            // Mostrar la etiqueta y el select de temas
                            $('label[for="tema"]').show();
                            $('#tema').show();

                            // Llenar el select de temas
                            $.each(JSONdata.temas, function (index, tema) {
                                console.log(tema);
                                $('#tema').append($('<option>', {
                                    value: tema.id_temas,
                                    text: tema.nombre
                                }));
                            });
                        } else {
                            // Si no hay temas, ocultar el select
                            $('#tema').hide();
                            $('label[for="tema"]').hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error al obtener los temas:', error);
                    }
                });
            }
        });
    });
</script>