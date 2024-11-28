<?php
  session_start();
  require_once 'datos/DAOProducto.php';
  
  if (!isset($_SESSION['usuario'])) {
      header('Location: login.php');
      exit();
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idProducto = $_POST['id'];
    $daoProducto = new DAOProducto();
    $daoProducto->vaciarProducto($idProducto);
    header('Location: productos.php');
    exit();
  }
?>