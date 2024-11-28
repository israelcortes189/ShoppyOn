<?php
session_start();
require_once('datos/DAOProducto.php');
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
$id = isset($_GET['id']) ? $_GET['id'] : null;
$producto = null;

if ($id) {
    $daoProducto = new DAOProducto();
    $producto = $daoProducto->obtenerProductoPorId($id);
    $imagen = $daoProducto->obtenerImagen($id);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle</title>
    <link rel="stylesheet" href="css/Descripcion.css">
</head>
<body>
<div class="barra">   
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
    <div class="contenedor contenido-principal cont">
        <main class="blog">
            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
            <div class="entrada">
                <img src="<?php echo htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8'); ?>" class="chaquetaAzul">
            </div>
        </main>
        <aside class="sidebar">
            <h3>Descripcion del Producto</h3>
            
            <div>
                <p class="widget-descripcion__label"><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></p>
            </div>
            <div>
                <h4>Precio Unitario: $<?php echo htmlspecialchars($producto['precio']); ?></h4>
            </div>
            <div class="botonAumentar">
                <span id="stockDisponible">Cantidad disponible: <?php echo htmlspecialchars($producto['stock']); ?></span>
            </div>
            <div class="separar">
               <form method="POST" action="carrito.php">
                   <input type="hidden" name="id_producto" value="<?php echo $producto['id']; ?>">
                   <input type="hidden" name="nombreProducto" value="<?php echo $producto['nombre']; ?>">
                   <h1>Cantidad a comprar: </h1>
                   <input type="number" id="cantidad" name="cantidad" value="1" min="1" max="<?php echo $producto['stock']; ?>"
                   title="No hay suficientes productos">
                   <button type="submit" id="boton2">AGREGAR AL CARRITO</button>
               </form>
            </div>
       </aside>
    </div>
    <br><br><br><br><br>

    <footer>
        <p>Benito Juárez #52, Uriangato, México</p>
        <p>Tienda de Ropa Deportiva Shoppy-on</p>
        <p>Correo de contacto <br>Shoppy-on@gmail.com</p>
        <p>Telefono de contacto <br> 444-214-1354</p>
        <p>&copy; 2024 Todos los derechos reservados</p>
    </footer>
</body>
</html>