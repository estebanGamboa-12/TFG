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
    .perfil {
        position: relative;
        display: flex;
        align-items: center;
    }

    .desplegable {
        position: absolute;
        width: auto;
        height: au;
        transform: translateY(-50%);
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 10px;
        display: block;
        z-index: 10;
    }

    .logo-usuario:hover+.desplegable,
    .desplegable:hover {
        display: block;
    }
</style>

<body>
    <div class="grid">
        <header>
            <div class="header">
                <div class="logo">
                    <div class="bars">☰</div>
                    <img src="<?= Parameters::$BASE_URL . "assets/img/logo1.jpg" ?>" alt="" class="logo-header">
                </div>
                <div class="tresPuntos">
                    <?php if (Authentication::isUserLogged()) { ?>
                        <div class="perfil">
                            <a class="CrearPost" href="<?= Parameters::$BASE_URL ?>Post/mostrarForm" style="text-decoration: none;">Crear Post</a>
                            <a href="<?= Parameters::$BASE_URL ?>Usuario/mostrarVetananCerrarSesion"><img class="logo-usuario" src="<?php echo  Parameters::$BASE_URL ?>assets/img/<?php echo $_SESSION['user']["imagen_logo_usuario"] ?>" alt=""></a>
                        </div>
                    <?php } else { ?>
                        <div class="iniciarSesion">Iniciar Sesion</div>
                        <i class="fa fa-ellipsis-h"></i>
                    <?php  }  ?>
                </div>
            </div>
        </header>
</body>
<!-- Ventana modal iniciar sesion .------------------------------------------------------ -->
<div class="modalIniciarSesion" id="modal-IniciarSesion">
    <div class="modal-content-sesion">
        <div class="cerrar">x</div>
        <div class="titulo-iniciarSesion">Iniciar Sesión</div>
        <form action="<?= Parameters::$BASE_URL ?>Usuario/iniciarSesion" method="post">
            <label for="nombre">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre de usuario" required>
            </label>
            <label for="contreaseña">
                <input type="password" name="contrasena" id="contraseña" placeholder="Contraseña" required>
            </label>
            <input type="submit" value="Iniciar Sesion">
        </form>
        <div class="texto-registro">¿Es tu primera vez en Foro? <a class="botonRegistrarse">Registrarse</a></div>
    </div>
</div>
<!-- ventana modal registrarse ----------------------------------------------------------------- -->
<div class="modalRegistrar" id="modal-registrarse">
    <div class="modal-content-registrarse">
        <div class="cerrar">x</div>
        <div class="titulo-registrarse">Registrarse</div>
        <form action="<?= Parameters::$BASE_URL ?> Usuario/registrarUsuarios" method="post">
            <label for="nombre">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre de usuario" required>
            </label>
            <label for="apellido">
                <input type="text" name="apellido" id="apellido" placeholder="apellido" required>
            </label>
            <label for="correo">
                <input type="email" name="email" id="email" placeholder="email" required>
            </label>
            <label for="contraseña">
                <input type="password" name="contraseña" id="contraseña " placeholder="contraseña" required>
            </label>
            <label for="repetir_contraseña">
                <input type="password" name="repetir_contraseña" id="repetir_contraseña" placeholder="Repetircontreaseña" required>
            </label>
            <input type="submit" value="Registrarse ">
        </form>
    </div>
</div>

<!-- 
<script>
    document.querySelector(".logo-usuario").addEventListener("click", () => {
        console.log("entra");
        fetch("<?= Parameters::$BASE_URL ?>Usuario/mostrarVentanaCerrarSesion", {
                method: "POST"
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => console.error(error));
    });
</script> -->

</html>