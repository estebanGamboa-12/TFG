<?php

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= Parameters::$BASE_URL . "assets/css/estilos.css" ?>">
    <link rel="stylesheet" href="<?= Parameters::$BASE_URL . "assets/css/logeado.css" ?>">
    <script src="<?= Parameters::$BASE_URL . "assets/js/script.js" ?>"></script>
    <!-- jquery y select multiple -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <title>Foro</title>
</head>
<style>
    .tooltip-container {
        position: relative;
        display: flex;
    }

    .user-icon {
        position: relative;
        display: inline-block;
    }

    .tooltip {
        position: absolute;
        top: 45px;
        left: 0%;
        width: 250px;
        transform: translateX(-90%);
        background-color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        text-align: center;
        z-index: 1;
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        flex-direction: column;
        ;
    }

    .tooltip::before {
        content: '';
        position: absolute;
        top: -40px;
        left: 0;
        width: 100%;
        height: 40px;
        pointer-events: auto;
    }

    .tooltip .nav-link {
        text-decoration: none;
        padding: 10px;
        color: #696969;
    }

    .tooltip span {
        text-align: left;
        color: #696969;
        padding: 0px 5px 5px 5px;
    }

    .tooltip span:first-of-type {
        padding: 5px 5px 0px 5px !important;
    }

    .tooltip .nav-link:hover {
        background-color: #e2e2e2;
        color: #696969;
        transition: all .5s;
        border-radius: 10px;
    }

    .tooltip-clicked {
        visibility: visible;
        opacity: 1;
    }
</style>


<body>
    <div class="grid">
        <header>
            <div class="header">
                <div class="bars">☰</div>
                <div class="tresPuntos">
                    <?php if (Authentication::isUserLogged()) { ?>
                        <div class="perfil">
                            <a class="CrearPost" href="<?= Parameters::$BASE_URL ?>Post/mostrarForm" style="text-decoration: none;">Crear Post</a>
                            <img src="<?= Parameters::$BASE_URL . "assets/img/logo1.jpg" ?>" alt="" class="logo-header">
                            <div class="listaUsuario">☰</div>
                        </div>
                    <?php } else { ?>
                        <a href="<?= Parameters::$BASE_URL ?>Usuario/verFormularioIniciarSesion">
                            <div class="iniciarSesion">Iniciar Sesion</div>
                        </a>
                        <i class="fa fa-ellipsis-h"></i>
                    <?php  }  ?>
                </div>
            </div>
            <div class="containerUsuario">
                <a href="<?= Parameters::$BASE_URL ?>Usuario/cerrarSesion">Cerrar Sesion</a>
            </div>
        </header>

</body>
<style>
    .containerUsuario {
        display: none;
        justify-items: flex-end;
        margin-right: 2%;

    }

    .containerUsuario a {
        padding: 5px 15px;
        border-radius: 1rem;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgb(0, 150, 136);
        font-family: Georgia, 'Times New Roman', Times, serif;
        color: black;
        font-size: 100%;
        width: 8rem;
    }
</style>

</html>
<script>
    if (document.querySelector('.listaUsuario')) {
        document.querySelector('.listaUsuario').addEventListener('click', function() {
            console.log("entra");
            document.querySelector('.containerUsuario').style.display = "grid";
        });
    }
</script>