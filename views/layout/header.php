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
</body>

</html>