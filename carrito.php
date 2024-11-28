<?php
session_start();
require_once('datos/DAOProducto.php');
require_once('datos/DAOCarrito.php');
require_once('datos/Conexion.php');

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;
$tipoMensaje = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : null;

unset($_SESSION['mensaje'], $_SESSION['tipo']);

$idusuario=$_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_producto = $_POST['id_producto'];

    $daoProducto = new DAOProducto();
    $producto = $daoProducto->obtenerProductoPorId($id_producto);
    
    $cantidad_a_comprar = $_POST['cantidad'];
    $NombreProducto = $_POST['nombreProducto'];
    $precioTotal= $producto['precio'] * $cantidad_a_comprar;

    $daoCarrito = new DAOCarrito();
    $daoCarrito->registrarCarrito($id_producto, $NombreProducto, $precioTotal, $cantidad_a_comprar, $idusuario);

    header("Location: index.php");
    exit();
}

$daoCarrito = new DAOCarrito();
$obtenerDatos = $daoCarrito->obtenerDatos($idusuario);
$daoDeProductos = new DAOProducto();

$total= $daoCarrito->sumaTotal($idusuario);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="css/carrito.css">
<style>
body {
    background-color: #fff;
    font-family: Arial, sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
}

.barra {
    background-color: #f8f8f8;
    padding: 15px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
    overflow: hidden;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ccc;
}

.barra ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
}

#nombreTienda {
    color: #333;
}

.barra ul li {
    margin-right: 20px;
}

.barra ul li a {
    color: #333;
    font-size: 20px;
    text-decoration: none;
    display: block;
    text-align: center;
    padding: 14px 20px;
}

.barra ul li a:hover {
    background-color: #eaeaea;
}

.barra .search-and-buttons {
    display: flex;
    align-items: center;
}

.container {
    display: flex; 
    flex-direction: column; 
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 500px;
    height: auto; 
}

.form-container {
    margin-left: 20px;
    display: inline-block;
    padding: 5px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 250px;
    height: 150px;
}

#boton2,
#boton3 {
    
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    background-color: #4CAF50;
    border: none;
    border-radius: 4px;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s;
}

#boton2:hover,
#boton3:hover {
    background-color: #45a049;
}

.barra input[type="text"] {
    padding: 6px;
    margin-top: 8px;
    margin-right: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.barra button {
    padding: 4px 10px;
    background-color: #555;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.barra button:hover {
    background-color: #444;
}

footer {
    background-color: #f8f8f8;
    color: #333;
    padding: 20px;
    text-align: center;
    left: 0;
    bottom: 0;
    width: 100%;
    border-top: 1px solid #ccc;
}

footer p {
    display: inline-block;
    padding-left: 14%;
    padding-right: 14%;
}

.list-group {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    flex-grow: 1;
    width: 100%; 
}

.list-group-item {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start; 
    padding: 5px;
    border-bottom: 1px solid #ccc;
    width: 80%; 
}

.chaquetaAzul {
    width: 80px;
    height: auto;
    margin-right: 15px;
}

.product-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.product-info span {
    font-size: 14px;
}

.wrapper {
    display: flex;
    justify-content: space-between;
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    gap: 20px; 
}

.mensaje {
        margin: 15px 0;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        font-weight: bold;
    }
    .mensaje.exito {
        background-color: #e8f5e9;
        color: #2e7d32;
    }
    .mensaje.error {
        background-color: #ffebee;
        color: #c62828;
    }
    .error-mensaje {
        color: red;
    }
    .contenedorQuitar{
       display: flex;
       margin-left: auto;
    }
    .btnEliminarProducto{
      background-color: #ffebee;
      cursor: pointer;
      border-radius: 5px;
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
    <div>
    <?php if ($mensaje): ?>
            <div id="mensaje" class="mensaje <?php echo htmlspecialchars($tipoMensaje); ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
    <?php endif; ?>
    </div>
    <div class= "wrapper">
        <div class="container">
            <ul class="list-group">
                <?php
                if (!empty($obtenerDatos)) {
                    foreach ($obtenerDatos as $row) {
                        $imagen = $daoDeProductos->obtenerImagenPorNombre($row["nombre_producto"]);
                        echo "<li class='list-group-item product-item'>";           
                        echo "<img src='" . htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8') . "' alt='Imagen del Producto' class='chaquetaAzul'>";
                        echo "<div class='product-info'>";
                        echo "<span>" . htmlspecialchars($row["nombre_producto"]) . "</span><br>";
                        echo '<span>Cantidad: <span type="number" class="cantidad-producto" 
                              data-id-producto="' . $row["idproducto"] . '" 
                              data-precio="' . $row["precio_total"] . '" 
                              value="' . htmlspecialchars($row["cantidad"]) . '" 
                              min="1"</span></span>';                  
                        echo "<span>$" . htmlspecialchars($row["precio_total"]) . "</span>";
                        echo "</div>";
                        echo "<form class='contenedorQuitar' action='quitarProducto.php' method='POST'>";
                        echo "<input type='hidden' name='idProducto' value='" . $row["idproducto"] . "'>"; 
                        echo "<button type='submit' class='btnEliminarProducto'>Quitar</button>";
                        echo "</form>";
                        echo "</li>";
                    }
                } else {
                    echo "<li class='list-group-item'>No has agregado productos al carrito</li>";
                }
                ?>
            </ul>
        </div>
        <script>
            
        const mensajeDiv = document.getElementById('mensaje');
        if (mensajeDiv) {
            setTimeout(() => {
                mensajeDiv.style.transition = 'opacity 1s ease';
                mensajeDiv.style.opacity = '0';
                setTimeout(() => {
                    mensajeDiv.style.display = 'none';
                }, 1000);
            }, 2500);
        }
/*
    document.getElementById('formCompra').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevenir el envío automático del formulario para comprobar errores

    const cantidades = document.querySelectorAll('.cantidad-producto');
    const contenedorDatos = document.getElementById('datosProductos');

    // Limpia el contenedor antes de agregar nuevos inputs
    contenedorDatos.innerHTML = '';

    // Verifica que haya al menos un producto
    if (cantidades.length === 0) {
        alert('No hay productos en el carrito.');
        return;
    }

    cantidades.forEach(input => {
        const idProducto = input.getAttribute('data-id-producto');
        const precioUnitario = input.getAttribute('data-precio');
        const cantidad = input.value;

        if (cantidad <= 0) {
            alert('La cantidad debe ser mayor a cero.');
            return;
        }

        // Crear los inputs ocultos para cada producto
        contenedorDatos.innerHTML += `
            <input type="hidden" name="productos[${idProducto}][id]" value="${idProducto}">
            <input type="hidden" name="productos[${idProducto}][cantidad]" value="${cantidad}">
            <input type="hidden" name="productos[${idProducto}][precioTotal]" value="${cantidad * precioUnitario}">
        `;
    });

    // Enviar el formulario una vez que los datos se han añadido correctamente
    console.log('Formulario listo para enviarse');
    this.submit();
});
*/

         </script>

        <div class="form-container">
        <?php echo "<p>Total a pagar: $" . htmlspecialchars($total) . "</p>";  ?>
            <form method="POST" action="realizarPago.php" id="formCompra">
                <input type="hidden" name="datosCarrito" value="<?php echo htmlspecialchars(json_encode($obtenerDatos), ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" id="boton2">Realizar Compra</button>
            </form>
            <form method="POST" action="eliminarCarrito.php">
                <button type="submit" id="boton3">Vaciar Carrito</button>
            </form>
        </div>
    </div>
    <br><br><br><br><br><br><br>
    <footer>
        <p>Benito Juárez #52, Uriangato, México</p>
        <p>Tienda de Ropa Deportiva Shoppy-on</p>
        <p>Correo de contacto <br>Shoppy-on@gmail.com</p>
        <p>Telefono de contacto <br> 444-214-1354</p>
        <p>&copy; 2024 Todos los derechos reservados</p>
    </footer>
</body>
</html>