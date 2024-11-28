<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
         header('Location: login.php');
         exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $datosCarrito = isset($_POST['datosCarrito']) ? json_decode($_POST['datosCarrito'], true) : [];
        
        if (empty($datosCarrito)) {
            $_SESSION['mensaje'] = "No hay productos agregados.";
            $_SESSION['tipo'] = "error";
            header('Location: carrito.php');
            exit();
        }
    }
    
/*
    require_once('datos/DAOCarrito.php');

    $idUsuario = $_SESSION['user_id'];
    $productos = $_POST['productos'];
    $carrito = new DAOCarrito();
      
        foreach ($productos as $producto) {
            if (isset($producto['id'], $producto['cantidad'], $producto['precioTotal'])) {
                $idProducto = $producto['id'];
                $cantidad = $producto['cantidad'];
                $precioTotal = $producto['precioTotal'];
    
                if ($carrito->actualizarCarrito($idProducto, $cantidad, $precioTotal, $idUsuario)) {
                    echo "Producto actualizado en el carrito con éxito.";
                } else {
                    echo "Error al actualizar el producto en el carrito.";
                }
            } else {
                echo "Datos del producto incompletos.";
            }
        }*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="css/realizarPago.css">
</head>
<body>
    <div class="barra cont">
        <ul>
            <li><a href="index.php" id="nombreTienda">SHOOPY-ON</a></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="perfilUsuario.php">Perfil</a></li>
            <li><a href="carrito.php">Carrito</a></li>
            <form action="cerrarSesion.php" method="POST" id="fr">
               <button type="submit" id="btnCerrarSesion">Cerrar Sesión</button>
            </form>
        </ul>    
    </div>
    <div>
    <div class="form-container">
        <form action="procesarCompra.php" method="POST">
            <div class="formularioPago">
                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required  minlength="5" maxlength="50">
            </div>
            <div class="formularioPago">
                <label for="ciudad">Ciudad:</label>
                <input type="text" id="ciudad" name="ciudad" placeholder="Ingresa tu ciudad" required minlength="5" maxlength="30">
            </div>
            <div class="formularioPago">
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" placeholder="Ingresa tu estado" required minlength="5"  maxlength="30">
            </div>
            <div class="formularioPago">
                <label for="codigo_postal">Código postal:</label>
                <input type="text" id="codigo_postal" name="codigo_postal" placeholder="Ingresa tu código postal" required minlength="5"  maxlength="5" pattern="[0-9]{5}">
            </div>

            <div class="formularioPago">
                <label for="tarjeta">Número de tarjeta:</label>
                <input type="text" id="tarjeta" name="tarjeta" placeholder="XXXX-XXXX-XXXX-XXXX" required minlength="16" maxlength="16" pattern="[0-9]{16}">
            </div>
            <div class="formularioPago">
                <label for="fecha_expiracion">Fecha de expiración:</label>
                <input type="month" id="fecha_expiracion" name="fecha_expiracion" required>
            </div>
            <div class="formularioPago">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" required minlength="3" maxlength="3" pattern="[0-9]{3}">
            </div>

            <div class="formularioPago">
                <input type="submit" value="Realizar pago">
            </div>
        </form>
    </div>
    <br><br>
    <footer>
        <p>Benito Juárez #52, Uriangato, México</p>
        <p>Tienda de Ropa Deportiva Shoppy-on</p>
        <p>Correo de contacto <br>Shoppy-on@gmail.com</p>
        <p>Telefono de contacto <br> 444-214-1354</p>
        <p>&copy; 2024 Todos los derechos reservados</p>
    </footer>
</body>
</html>