<?php
session_start();
require_once('datos/Conexion.php');
require_once('datos/DAOProducto.php');
require_once('datos/DAOVentas.php');
require_once('modelos/Venta.php');
require_once('datos/DAOCarrito.php');

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$success = false;
$message = '';

    $idUsuario = $_SESSION['user_id'];

    $daoCarrito= new DAOCarrito();
    $suma= $daoCarrito->sumaTotal($idUsuario);

    $daoProducto= new DAOProducto();

    $daoVentas = new DAOVentas();
    if($suma){
        $idVentaRegistrada = $daoVentas->registrarVenta($idUsuario, $suma);
    }else{
        $_SESSION['mensaje'] = "No tienes Productos Agregados en el carrito.";
        $_SESSION['tipo'] = "error";
        header("Location: carrito.php");
    }
    
    if ($idVentaRegistrada) {
        $productos= $daoCarrito->obtenerProducto($idUsuario);
        $daoCarrito->eliminarCarrito($idUsuario);

        $listaDeProductos = [];
        $listadoCantidad=[];
        $listadoActualizado=[];
        foreach ($productos as $producto) {
            $listaDeProductos[] = [
                'cantidad' => $producto['cantidad'],
            ];
            $listadoCantidad[] = [
                'stock' => $daoProducto->obtenerCantidad($producto['idproducto'])
            ];
        }

        for ($i = 0; $i < count($listaDeProductos); $i++) {
            $cantidadOriginal = $listadoCantidad[$i]['stock'];
            $cantidadRestada = $listaDeProductos[$i]['cantidad'];
            $listadoActualizado[] = [
                'cantidad' => $cantidadOriginal - $cantidadRestada
            ];
        }

        $listadoCantidadProducto = [];
        for ($i = 0; $i < count($productos); $i++) {
            $producto = $productos[$i];
            $cantidadActualizada = $listadoActualizado[$i]['cantidad'];
            
            $listadoCantidadProducto[] = [
                'cantidad' => $cantidadActualizada,
                'idProducto' => $producto['idproducto']
            ];
        }
        $algo=$daoProducto->actualizarCantidades($listadoCantidadProducto);
    } else {
        $message .= " Error al registrar venta. Por favor, inténtalo de nuevo más tarde.";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la Compra</title>
    <link rel="stylesheet" href="css/Descripcion.css">
    <link rel="stylesheet" href="css/actualizarCantidad.css">

    <style>
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            padding-left: 10px;
        }
        .blog{
            margin-left: 28%;
        }
    </style>

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
    <div class="contenedorPrincipal">
        <main class="blog">
            <h3>Compra realizada Correctamente</h3>
            <p>Productos Comprados:</p>
                <div>
                <?php if (!empty($productos)): ?>
                    <ul>
                        <?php foreach ($productos as $producto): ?>
                            <li>
                                <?php echo htmlspecialchars($producto['nombre_producto']); ?> - Cantidad: <?php echo htmlspecialchars($producto['cantidad']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No hay productos en el carrito.</p>
                <?php endif; ?>
                </div>
            <p>Precion Total: $<?php echo $suma;?></p>
        </main>
    </div>
    <footer>
        <p>Benito Juárez #52, Uriangato, México</p>
        <p>Tienda de Ropa Deportiva Shoppy-on</p>
        <p>Correo de contacto <br>Shoppy-on@gmail.com</p>
        <p>Telefono de contacto <br> 444-214-1354</p>
        <p>&copy; 2024 Todos los derechos reservados</p>
    </footer>
</body>
</html>