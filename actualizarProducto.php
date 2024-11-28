<?php
session_start();
require_once 'datos/DAOProducto.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idProducto = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $errores = [];

    if (strlen($nombre) < 3 || strlen($nombre) > 50) {
        $errores[] = "El nombre debe tener entre 3 y 50 caracteres.";
    }

    if (strlen($direccion) > 150) {
        $errores[] = "La descripcion no puede tener más de 150 caracteres.";
    }

    if (count($errores) == 0) {
        $resultado = $DAOProducto->actualizarProductoPorId($idProducto, $nombre, $descripcion, $precio, $stock);
     }

    if ($resultado) {
        header('Location: productos.php?mensaje=' . urlencode('Producto actualizado correctamente.'));
        exit();
    } else {
        header('Location: editarProducto.php?id=' . $id . '&mensaje=' . urlencode('Error al actualizar el usuario.'));
        exit();
    }
}
?>
