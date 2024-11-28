<?php
require_once("datos/DAOUsuarios.php");
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $daoUsuarios = new DAOUsuarios();
    if ($daoUsuarios->inactivarUsuario($_POST['id'])) {
        header("Location: Usuarios.php?msg=Usuario eliminado exitosamente");
        exit();
    } else {
        header("Location: Usuarios.php?msg=Error al eliminar usuario");
        exit();
    }
}
?>
