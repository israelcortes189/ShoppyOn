<?php
require_once 'datos/DAOUsuarios.php';
require_once 'modelos/usuario.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["email"]) && isset($_POST["contrasenia"])&& isset($_POST["telefono"])&& isset($_POST["direccion"])) {
        $nombre = $_POST["nombre"];
        $email = $_POST["email"];
        $contrasenia = $_POST["contrasenia"];
        $telefono = $_POST["telefono"];
        $direccion = $_POST["direccion"];
        $activo= true;

        $errores = [];

        if (strlen($nombre) < 3 || strlen($nombre) > 30) {
            $errores[] = "El nombre debe tener entre 3 y 30 caracteres.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo no tiene un formato válido.";
        }

        if (!preg_match('/^[0-9]{10}$/', $telefono)) {
            $errores[] = "El teléfono debe tener 10 dígitos numéricos.";
        }

        if (strlen($direccion) > 100) {
            $errores[] = "La dirección no puede tener más de 100 caracteres.";
        }

        if (strlen($contrasenia) < 6 || strlen($contrasenia) > 8) {
            $errores[] = "La contraseña debe tener entre 6 y 8 caracteres.";
        }

        if (empty($errores)){
            $usuario = new Usuario($nombre, $email, $contrasenia, $telefono, $direccion, 1);
            $daoUsuario = new DAOUsuarios();
    
            $idUsuarioRegistrado = $daoUsuario->registrarUsuario($usuario);
    
            if ($idUsuarioRegistrado) {
                $_SESSION['mensaje'] = "Usuario registrado correctamente.";
                $_SESSION['tipo'] = "exito"; // Tipo de mensaje
                header("Location: login.php");
            } else {
                $_SESSION['mensaje'] = "El correo ya esta registrado.";
                $_SESSION['tipo'] = "error";
                header("Location: registro.php");
                exit();
            }
        }else {
            $_SESSION['mensaje'] = implode("<br>", $errores); // Unir errores en una sola cadena
            $_SESSION['tipo'] = "error";
        }
    } else {
        $_SESSION['mensaje'] = "Faltan datos del formulario.";
        $_SESSION['tipo'] = "error";
    }
} else {
    $_SESSION['mensaje'] = "Error al enviar una solicitud.";
    $_SESSION['tipo'] = "error";
    header("Location: registro.php");
    exit();
}
?>