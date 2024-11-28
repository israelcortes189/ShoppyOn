<?php
session_start();
require_once 'datos/DAOUsuarios.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $errores = [];

    if (strlen($nombre) < 3 || strlen($nombre) > 30) {
        $errores[] = "El nombre debe tener entre 3 y 30 caracteres.";
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo no tiene un formato válido.";
    }

    if (!preg_match('/^[0-9]{10}$/', $telefono)) {
        $errores[] = "El teléfono debe tener 10 dígitos numéricos.";
    }

    if (strlen($direccion) > 100) {
        $errores[] = "La dirección no puede tener más de 100 caracteres.";
    }

    if (count($errores) == 0) {
       $daoUsuario = new DAOUsuarios();
       $resultado = $daoUsuario->actualizarUsuario($id, $nombre, $correo, $telefono, $direccion);
    }

    if ($resultado) {
        $_SESSION['usuario']['nombre'] = $nombre;
        $_SESSION['usuario']['correo'] = $correo;
        header('Location: Usuarios.php?mensaje=' . urlencode('Usuario actualizado correctamente.'));
        exit();
    } else {
        header('Location: editarUsuario.php?id=' . $id . '&mensaje=' . urlencode('Error al actualizar el usuario.'));
        exit();
    }
}
?>
