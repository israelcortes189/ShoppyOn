<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
require_once('datos/DAOCarrito.php');

    $idusuario=$_SESSION['user_id'];

    $daoCarrito= new DAOCarrito();
    $daoCarrito->eliminarCarrito($idusuario);

    header("Location: carrito.php");

?>