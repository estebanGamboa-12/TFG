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
    .nombreComunidad{
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial;

    }
    .miembrosComunidad ,.parteAbajo{
        font-family: serif;
        color: grey;

    }
</style>

<?php

use admin\foro\Helpers\Authentication;
use admin\foro\Config\Parameters;

$comunidades = $data['comunidades'] ?? NULL;
$membresias=$data['membresias']??NULL;

if (!Authentication::isUserLogged()) {
    header("Location:" . Parameters::$BASE_URL);
}
?>
<section>
    <div class="section">

        <div class="conteiner-comunidades">
            <?php foreach ($comunidades as $indice => $contenido) {
            ?>
                <div id="card-comunidades">
                    <div class="parteArriba">
                        <img src="<?= Parameters::$BASE_URL ?>assets/img/<?php echo $contenido["imagen"] ?>" alt="" class="logo-comunidades">
                        <div class="nombreComunidad"><?php echo $contenido['nombre'] ?>
                            <div class="miembrosComunidad"><?= $membresias[$contenido['id']] ?> miembros</div>
                        </div>
                        <div class="botonUnirte">join</div>
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