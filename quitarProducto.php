<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
         header('Location: login.php');
         exit();
    }

    require_once('datos/DAOCarrito.php');

    $idUsuario = $_SESSION['user_id'];
    $productoId = $_POST['idProducto'];
    $daoCarrito = new DAOCarrito();

    if($daoCarrito->eliminarProductoDelCarrito($productoId, $idUsuario)) {
      header('Location: carrito.php');
      exit();
    }else{
      echo "Error";
    }
?>