<?php 
use admin\foro\Config\Parameters;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=Parameters::$BASE_URL . "assets/css/estilos.css" ?>">
    <script src="<?=Parameters::$BASE_URL . "assets/js/script.js" ?>"></script>
    <title>Foro</title>
</head>

<body>
    <div class="grid">
        <header>
            <div class="header">
                <div class="logo">
                    <div class="bars">☰</div>
                    <img src="<?= Parameters::$BASE_URL ."assets/img/logo1.jpg"?>" alt="" class="logo-header">
                </div>
                <div class="tresPuntos">
                    <div class="iniciarSesion">Iniciar Sesion</div>
                    <i class="fa fa-ellipsis-h"></i>
                </div>
            </div>
        </header>      
    
    <!-- Ventana modal iniciar sesion .------------------------------------------------------ -->
    <div class="modalIniciarSesion" id="modal-IniciarSesion">
        <div class="modal-content-sesion">
            <div class=" cerrar">x</div>
            <div class="titulo-iniciarSesion">Iniciar Sesión</div>
            <form action="index.php?ctl=iniciarSesion" method="post">
                <label for="nombre">
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre de usuario" required>
                </label>
                <label for="contreaseña">
                    <input type="password" name="contrasena" id="contraseña" placeholder="Contraseña" required>
                </label>

                <input type="submit" value="Iniciar Sesion">
            </form>
            <div class="texto-registro">¿Es tu primera vez en Foro? <a class="botonRegistrarse" href="#">Registrarse</a></div>
        </div>
    </div>
    <!-- ventana modal registrarse ----------------------------------------------------------------- -->
    <div class="modalRegistrar" id="modal-registrarse" >
        <div class="modal-content-registrarse">
            <div class="cerrar">x</div>
            <div class="titulo-registrarse">Registrarse</div>
            <form action="index.php?ctl=registrar" method="post">
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
    
</body>

</html>