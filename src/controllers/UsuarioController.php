<?php

namespace admin\foro\Controllers;

use admin\foro\Config\Parameters;
use admin\foro\Helpers\Authentication;
use admin\foro\Helpers\GenerarToken as HelpersGenerarToken;
use admin\foro\Helpers\ImageUploader;
use admin\foro\Models\PostModel;
use admin\foro\Models\UsuarioModel;
use Firebase\JWT\JWT;

class UsuarioController
{
    public function cerrarSesion()
    {
        unset($_SESSION['user']);
        header("location:" . Parameters::$BASE_URL);
    }
    public function mostrarVetananCerrarSesion()
    {
        $_SESSION['cambioVista'] = "cerrarSesion";
    }
    public function verFormularioIniciarSesion()
    {
        if (Authentication::isUserLogged()) {
            header("Location: " . Parameters::$BASE_URL . "Post/home");
            exit;
        }
        ViewController::show("views/usuario/formularioIniciarSesion.php");
        exit;
    }
    public function verFormularioEditarUsuario()
    {
        if (Authentication::isUserLogged()) {
            $idUsario = $_SESSION['user']['idUsuario'];
            $usuarioModel = new UsuarioModel();
            $datosUsuario = $usuarioModel->usuarioPorId($idUsario);
            ViewController::show("views/usuario/formularioEditarUsuario.php", ["datosUsuario" => $datosUsuario]);
        } else {
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
        }
    }
    public function editarUsuario()
    {
        if (Authentication::isUserLogged()) {
            $idUsario = $_SESSION['user']['idUsuario'];
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $contrasena = $_POST['contraseña'] ?? '';
            $repetir_contrasena = $_POST['repetir_contraseña'] ?? '';
            $imagen = $_FILES['imagen'] ?? null;

            $errores = [];

            // Validaciones de los campos
            if (!empty($nombre) && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
                $errores[] = "El nombre solo puede contener letras y espacios.";
            }

            if (!empty($apellido) && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $apellido)) {
                $errores[] = "El apellido solo puede contener letras y espacios.";
            }

            if (!empty($correo) && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $errores[] = "El correo electrónico no es válido.";
            }

            if (!empty($contrasena) && !empty($repetir_contrasena) && $contrasena !== $repetir_contrasena) {
                $errores[] = "Las contraseñas no coinciden.";
            }

            if (!empty($errores)) {
                $_SESSION['errores'] = $errores;
                header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioEditarUsuario");
                exit;
            } else {
                // Obtener los datos actuales del usuario desde la base de datos
                $usuarioModel = new UsuarioModel();
                $usuarioActual = $usuarioModel->usuarioPorId($idUsario);

                // Verificar si la contraseña fue modificada
                if (!empty($contrasena)) {
                    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
                } else {
                    $contrasenaHash = $usuarioActual['contraseña']; // Mantener la contraseña actual si no se cambió
                }

                // Verificar si se subió una nueva imagen
                if ($imagen && $imagen['error'] === UPLOAD_ERR_OK) {
                    $imagenUploader = new ImageUploader();
                    $imagenSubida = $imagenUploader->subirImagen($imagen);
                    $nombreImagen = $imagenSubida;
                } else {
                    $nombreImagen = $usuarioActual['imagen_logo_usuario'];
                }

                // Ahora actualizamos los campos que han cambiado
                $verificar = $usuarioModel->editarUsuario($nombre, $apellido, $correo, $contrasenaHash, $nombreImagen, $idUsario);
                $usuarioModificado = $usuarioModel->usuarioPorId($idUsario);
                $_SESSION['user'] = [
                    "idUsuario" => $usuarioModificado['id_usuario'],
                    'nombre' => $usuarioModificado['nombre'],
                    'imagen_logo_usuario' => $usuarioModificado['imagen_logo_usuario'],
                ];

                if ($verificar) {
                    if (!empty($contrasena)) {
                        header('Location: ' .Parameters::$BASE_URL. "Usuario/cerrarSesion");
                        exit;
                    } else {
                        header("Location: " . Parameters::$BASE_URL . "Post/home");
                        exit;
                    }
                } else {
                    $_SESSION['errores'] = ["Hubo un error al actualizar el usuario"];
                    header("Location: " . Parameters::$BASE_URL . "Usuario/verFormularioEditarUsuario");
                    exit;
                }
            }


        } else {
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
        }
    }
    public function mostrarFormularioRegistrar()
    {
        if (Authentication::isUserLogged()) {
            header("Location: " . Parameters::$BASE_URL . "Post/home");
            exit;
        }
        ViewController::show("views/usuario/formularioRegistrarUsuario.php");
        exit;
    }

    public function iniciarSesion()
    {
        session_start(); // Asegurarse de que la sesión está iniciada
        $usuarioModel = new UsuarioModel();
        $nombre = $_REQUEST['nombre'];
        $contrasena = $_REQUEST['contraseña'];
        $errores = []; // Arreglo para almacenar errores

        // Validar que ambos campos estén completos
        if (empty($nombre)) {
            $errores[] = "El campo de nombre de usuario está vacío.";
        }
        if (empty($contrasena)) {
            $errores[] = "El campo de contraseña está vacío.";
        }

        if (!empty($errores)) {
            // Si hay errores, redirigir con mensajes
            $_SESSION['errores'] = $errores;
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
        }

        // Obtener datos del usuario desde el modelo
        $datos = $usuarioModel->buscarUsuarioPorNombre($nombre);

        if (!$datos) {
            // Si no se encuentra el usuario
            $errores[] = "El nombre de usuario o la contraseña son incorrectos.";
            $_SESSION['errores'] = $errores;
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
        }

        // Comparar contraseña ingresada con la almacenada en la base de datos
        if (!password_verify($contrasena, $datos['contraseña'])) {
            // Contraseña incorrecta
            $errores[] = "El nombre de usuario o la contraseña son incorrectos.";
            $_SESSION['errores'] = $errores;
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
        }

        // Si todo está bien, redirigir al home de posts
        $_SESSION['usuario'] = $datos['nombre']; // Iniciar sesión con el nombre del usuario
        header('Location: ' . Parameters::$BASE_URL . 'Post/home');
        exit;
    }

    public function registrarUsuario()
    {
        $usuarioModel = new UsuarioModel();
        $imagenUploader = new ImageUploader();

        // Obtener datos del formulario
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $email = trim($_POST['correo'] ?? '');
        $contrasena = $_POST['contraseña'] ?? '';
        $repetirContrasena = $_POST['repetir_contraseña'] ?? '';
        $imagen = $_FILES['imagen'] ?? null;

        // Inicializar mensajes de error
        $errores = [];

        // Validaciones de los campos
        if (empty($nombre) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
            $errores[] = "El nombre solo puede contener letras y espacios.";
        }

        if (empty($apellido) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $apellido)) {
            $errores[] = "El apellido solo puede contener letras y espacios.";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no es válido.";
        }

        if (empty($contrasena) || strlen($contrasena) < 6) {
            $errores[] = "La contraseña debe tener al menos 6 caracteres.";
        }

        if ($contrasena !== $repetirContrasena) {
            $errores[] = "Las contraseñas no coinciden.";
        }

        if (!$imagen || $imagen['error'] !== UPLOAD_ERR_OK) {
            $errores[] = "Debe subir una imagen válida.";
        }
        $usuario = $usuarioModel->comprobarUsuario($nombre);
        if ($usuario) {
            $errores[] = "El nombre de usuario ya existe.";
        }


        // Si hay errores, redirigir al formulario con mensajes de error
        if (!empty($errores)) {
            $_SESSION['errores'] = $errores;
            header("location:" . Parameters::$BASE_URL . "Usuario/mostrarFormularioRegistrar");
            exit;
        }

        // Procesar la imagen
        $imagen = $imagenUploader->subirImagen($imagen);

        // Encriptar la contraseña
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Registrar el usuario en la base de datos
        $comprobar = $usuarioModel->registrarUsuario($nombre, $apellido, $email, $contrasenaHash, $imagen);

        if ($comprobar) {
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
        } else {
            // No se pudo registrar el usuario
            session_start();
            $_SESSION['errores'] = ["No se pudo registrar el usuario. Intente nuevamente."];
            header("location:" . Parameters::$BASE_URL . "Usuario/mostrarFormularioRegistrar");
            exit;
        }
    }


    public function verUsuario()
    {
        if (Authentication::isUserLogged()) {
            $_SESSION['cambioVista'] = "perfilUsuario";
            $usuarioModel = new UsuarioModel();
            $postModel = new PostModel();
            $generarToken = new HelpersGenerarToken();
            $nombre = $_GET['nombre'];
            $token = [];
            $usuario = $usuarioModel->buscarUsuarioPorNombre($nombre);
            if ($usuario) {
                $idUsuarioPerfil = $usuario['id_usuario'];
                $idUsuarioVisita = $_SESSION['user']['idUsuario'];
                $_SESSION['usuarioVer'] = $usuario;


                $posts = $postModel->postPorUsuario($idUsuarioPerfil, $idUsuarioVisita);
                foreach ($posts as $post) {
                    $idUsuario = $_SESSION['user']['idUsuario'];
                    if ($post['id_comunidad'] !== NULL || $post['id_usuario'] || $post['id_post']) {
                        $token[$post['id_post']] = $generarToken->generarToken($idUsuario, $post['id_comunidad'], $post['id_post']);
                    } else {
                        $post['jwt_token'] = null;
                    }
                }
                ViewController::show("views/usuario/verUsuario.php", ["post" => $posts, "token" => $token, "usuario" => $usuario]);
            } else {
                header('location: ' . Parameters::$BASE_URL . "Post/home");
                exit;
            }
        } else {
            header("location:" . Parameters::$BASE_URL . "Usuario/verFormularioIniciarSesion");
            exit;
        }
    }
}
