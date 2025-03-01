<?php

use admin\foro\Helpers\Authentication;
use admin\foro\Config\Parameters;

$comunidades = $data['comunidades'] ?? NULL;
$membresias = $data['membresias'] ?? NULL;
$token = $data['tokens'] ?? NULL;
$idUsuario = $_SESSION['user']['idUsuario'];

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
        <div class="contenido"></div>
        <div class="conteiner-comunidades">
            <?php foreach ($comunidades as $indice => $contenido) {
                ?>
                <div id="card-comunidades">
                    <div class="parteArriba">
                        <a
                            href="<?= Parameters::$BASE_URL ?>Comunidades/verComunidad?nombreComunidad=<?= $contenido['nombre'] ?>">
                            <img src="<?= Parameters::$BASE_URL . 'assets/img/' . $contenido['imagen'] ?>" alt="imagen"
                                class="imagenLogo-section">
                        </a>
                        <div class="nombreComunidad"><?php echo $contenido['nombre'] ?>
                            <div class="miembrosComunidad" data-token="<?= $token[$contenido['id_comunidad']] ?>">
                                <?= $membresias[$contenido['id_comunidad']] ?> miembros
                            </div>
                        </div>
                        <?php if ($contenido["esta_unido"] == 0) { ?>
                            <div class="botonUnirte unirse" data-token="<?= $token[$contenido['id_comunidad']] ?>">Unirte</div>
                        <?php } else { ?>
                            <div class="dejarDeSeguir">
                                <a href="<?=Parameters::$BASE_URL?>Membresias/dejarSeguir?idComunidad=<?=$contenido['id_comunidad']?>">
                                Dejar de seguir</div>
                                </a>
                        <?php } ?>
                    </div>
                    <div class="parteAbajo">
                        <?php echo $contenido['descripcion'] ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    </div>
</section>
<style>
    .dejarDeSeguir {
        border-radius: 1rem;
        background-color: rgb(175, 51, 51);
        block-size: 2rem;
        inline-size: 7rem;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        cursor: pointer;
    }
    section {
  grid-column: 2/4;
  grid-row: 2;
  margin: 0% 3%;
  overflow-y: auto;
}
.second-aside {
    display: none;
}
</style>
<script>
    function actualizarCamposGenericos(url, token) {
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                "token": token,
            })
        })
            .then(response => response.text()) // Cambiar a .text() para ver lo que llega como respuesta
            .then(data => {
                try {

                    let jsonData = JSON.parse(data); // Intentamos parsear la respuesta
                    document.querySelector('.contenido').style.display = "flex";
                    // Comprobamos la respuesta completa
                    console.log("Valor de success:" + data);
                    if (jsonData.success === true) {
                        let numeroMiembros = document.querySelector(`.miembrosComunidad[data-token="${token}"]`);
                        if (numeroMiembros) {
                            numeroMiembros.innerHTML = `${jsonData.miembros} miembros`;
                        }
                        //success
                        document.querySelector('.contenido').innerHTML = jsonData.message;
                        document.querySelector('.contenido').classList.add("verde");
                        setTimeout(() => {
                            document.querySelector('.contenido').classList.remove("verde");
                            document.querySelector('.contenido').style.display = "none";
                        }, 2000);
                    } else {
                        //error
                        document.querySelector('.contenido').innerHTML = jsonData.message;
                        document.querySelector('.contenido').classList.add("rojo");
                        setTimeout(() => {
                            document.querySelector('.contenido').classList.remove("rojo");
                            document.querySelector('.contenido').style.display = "none";
                        }, 2000);

                    }
                } catch (error) {
                    console.log("se va al else2");
                    alert('Error al procesar la respuesta del servidor.', error);
                }
            })
            .catch(error => {
                console.error('Error en la solicitud fetch:', error);
            });
    }
    // ------------------UNIRSE---------------------------------- 
    document.querySelectorAll('.unirse').forEach(botonUnirse => {
        botonUnirse.addEventListener('click', function () {
            let token = botonUnirse.getAttribute('data-token'); // Obtener el token de la comunidad
            const url = '<?= Parameters::$BASE_URL ?>Membresias/unirseComunidad'; // URL de la solicitud

            // Verificar que el token esté presente
            if (token) {
                // Mostrar mensaje de carga
                let contenido = document.querySelector('.contenido');
                contenido.style.display = "flex";
                contenido.innerHTML = "Cargando..."; // Aquí podrías agregar un spinner
                contenido.classList.remove("rojo", "verde"); // Eliminar clases anteriores

                // Llamar a la función para realizar la solicitud
                actualizarCamposGenericos(url, token);
            } else {
                console.log("se va al else1");
                // Mostrar mensaje de error si no se encuentra el token
            }
        });
    });
</script>