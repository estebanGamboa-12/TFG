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
    <link rel="stylesheet" href="<?= Parameters::$BASE_URL . "assets/css/estilos.css" ?>">
    <link rel="stylesheet" href="<?= Parameters::$BASE_URL . "assets/css/logeado.css" ?>">
    <script src="<?= Parameters::$BASE_URL . "assets/js/script.js" ?>"></script>
    <title>Foro</title>
</head>

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
                            <a class="CrearPost" href="<?= Parameters::$BASE_URL?>Post/mostrarForm" style="text-decoration: none;">Crear Post</a>
                            <div class="nombre-usuario"><?php echo $_SESSION['user']["nombre"] ?></div>
                            <img src="<?php echo  Parameters::$BASE_URL ?>assets/img/<?php echo $_SESSION['user']["imagen_logo_usuario"] ?>" alt="">
                        </div>
                    <?php } else { ?>
                        <div class="iniciarSesion">Iniciar Sesion</div>
                        <i class="fa fa-ellipsis-h"></i>
                    <?php  }  ?>
                </div>
            </div>
        </header>
</body>

</html>