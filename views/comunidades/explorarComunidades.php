<style>
    a {
        text-decoration: none;
    }

    #card-comunidades {
        border-radius: 1rem;
        display: flex;
        padding: 1%;
        border: 1px solid gray;
        width: 15rem;
        margin: 3% 3%;
        flex-direction: column;
    }

    .parteArriba {
        display: flex;
        justify-content: space-between;

    }

    .parteAbajo {
        display: flex;
        justify-content: flex-start;
        margin-top: 5%;
    }

    .conteiner-comunidades {
        display: flex;
        flex-wrap: wrap;
    }

    .logo-comunidades {
        border-radius: 1rem;
        width: 2rem;
        height: 2rem;
    }

    section {
        grid-column: 2 / 4;
        grid-row: 2;
        margin: 0% 3%;
        overflow-y: auto;
    }

    .second-aside {
        display: none;
    }

    .botonUnirte {
        border-radius: 1rem;
        background-color: #009688;
        height: 2rem;
        width: 5rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .nombreComunidad {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial;

    }

    .miembrosComunidad,
    .parteAbajo {
        font-family: serif;
        color: grey;

    }

    .contenido {
        height: 50px;
        background-color: blue;
        z-index: 1000;
        position: sticky;
        top: 0;
        width: 100%;
        justify-content: center;
        display: none;
        justify-content: center;
        align-content: flex-start;
        align-items: center;
        font-size: 1.5rem;
    }

    .verde {
        background-color: #009688;
        color: black;
    }

    .rojo {
        background-color: red;
        color: black;
    }
</style>

<?php

use admin\foro\Helpers\Authentication;
use admin\foro\Config\Parameters;

$comunidades = $data['comunidades'] ?? NULL;
$membresias = $data['membresias'] ?? NULL;
$idUsuario = $_SESSION['user']['idUsuario'];

?>
<section>
    <div class="section">
        <div class="contenido">asdsadasdassad</div>
        <div class="conteiner-comunidades">
            <?php foreach ($comunidades as $indice => $contenido) {
            ?>
                <div id="card-comunidades">
                    <div class="parteArriba">
                        <img src="<?= Parameters::$BASE_URL ?>assets/img/<?php echo $contenido["imagen"] ?>" alt="" class="logo-comunidades">
                        <div class="nombreComunidad"><?php echo $contenido['nombre'] ?>
                            <div class="miembrosComunidad" data-id-comunidad="<?= $contenido['id_comunidad'] ?>"><?= $membresias[$contenido['id_comunidad']] ?> miembros</div>
                        </div>
                        <div class="botonUnirte unirse"
                            data-id-usuario="<?= $idUsuario ?>"
                            data-id-comunidad="<?= $contenido['id_comunidad'] ?>">Unirte</div>
                    </div>
                    <div class="parteAbajo">
                        <?php echo $contenido['descripcion'] ?>
                    </div>
                </div>
            <?php  } ?>
        </div>
    </div>
    </div>
</section>

<script>
    function actualizarCamposGenericos(url, idComunidad, idUsuario, valor) {
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    "idComunidad": idComunidad,
                    "idUsuario": idUsuario
                })
            })
            .then(response => response.text()) // Cambiar a .text() para ver lo que llega como respuesta
            .then(data => {
                try {

                    let jsonData = JSON.parse(data); // Intentamos parsear la respuesta
                    document.querySelector('.contenido').style.display = "flex";
                    // Comprobamos la respuesta completa
                    console.log("Valor de success:" + jsonData.success);
                    if (jsonData.success === true) {
                        let numeroMiembros = document.querySelector(`.miembrosComunidad[data-id-comunidad="${idComunidad}"]`);
                        if (numeroMiembros) {
                            numeroMiembros.innerHTML = `${jsonData.miembros} miembros`;
                        }
                        //success
                        document.querySelector('.contenido').innerHTML = jsonData.message;
                        document.querySelector('.contenido').classList.add("verde");
                        setTimeout(() => {
                            document.querySelector('.contenido').classList.remove("verde");
                            document.querySelector('.contenido').style.display = "none";
                            mensaje.remove();
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
                    alert('Error al procesar la respuesta del servidor.', 'error');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud fetch:', error);
            });
    }
    // ------------------UNIRSE---------------------------------- 
    document.querySelectorAll('.unirse').forEach(botonUnirse => {
        botonUnirse.addEventListener('click', function() {
            let comunidad = botonUnirse.getAttribute('data-id-comunidad'); // Obtener el id de la comunidad
            let usuario = botonUnirse.getAttribute('data-id-usuario'); // Obtener el id del usuario

            // Aquí puedes ajustar la URL de la solicitud si la necesitas, por ejemplo:
            const url = '<?= Parameters::$BASE_URL ?>Membresias/unirseComunidad';

            if (comunidad) {
                console.log("Usuario " + usuario + " se unirá a la comunidad " + comunidad);
                actualizarCamposGenericos(url, comunidad, usuario); // Llamar a la función con los valores seleccionados
            } else {
                alert('¡Algo salió mal! No se pudo procesar la solicitud.');
            }
        });
    });
</script>