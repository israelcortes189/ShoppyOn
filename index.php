<?php
session_start();
require_once("datos/DAOUsuarios.php");
require_once("datos/DAOProducto.php");

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
$daoUsuario = new DAOUsuarios();
$usuarios = $daoUsuario->obtenerUsuarioporId($_SESSION['user_id']);

if (isset($_SESSION['user_id'])) {
    $idInicio = $_SESSION['user_id'];
    if ($idInicio === 1) {
        header('Location: Usuarios.php'); 
        exit();
    }
    if($usuarios['activo'] === false){
        $_SESSION['mensaje'] = "Correo no registrado.";
        $_SESSION['tipo'] = "error"; 
        header("Location: login.php");
        exit();
    }
}else{
    header('Location: login.php');
    exit();
}

$daoProductos = new DAOProducto();
$productos = $daoProductos->obtenerTodosLosProductos();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoopy-on</title>
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <div class="barra">
        <ul>
            <li><a href="index.php" id="nombreTienda">SHOOPY-ON</a></li>
            <li><a href="">Home</a></li>
            <li><a href="perfilUsuario.php">Perfil</a></li>
            <li><a href="carrito.php">Carrito</a></li>
            <form action="cerrarSesion.php" method="POST" id="fr">
               <button type="submit" id="btnCerrarSesion">Cerrar Sesión</button>
            </form>
        </ul>    
    </div>

    <header>
        <h1>SHOPPY-ON</h1>
    </header>
    <main>
        <div class="Fotos">
            <div id="imagen-principal">
                <a>
                    <img src="https://th.bing.com/th/id/OIP.toLEj7fjIpbTG-LnxkSg9AHaEW?w=313&h=184&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                </a>
            </div>
            <h2>CAMISAS DEPORTIVAS DE HOMBRE A LA MODA</h2>
            <div class="columnas">
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 1) {
                        $productoAMostrar = $producto;
                        break;
                    }
                  }
                ?>
                    <a href="Descripcion.php?id=1" style="margin-right: 20px;">
                        <div class="Neglo">
                            <img class="a" src="https://th.bing.com/th/id/OIP.BPwJuL9rvxHLBp1af7UObAHaIH?w=178&h=195&c=7&r=0&o=5&dpr=1.5&pid=1.7" alt="Producto 1">
                            <?php echo "<p>" . htmlspecialchars($productoAMostrar['nombre']) . "</p>";  ?>
                            <?php echo "<p>" . htmlspecialchars($productoAMostrar['precio']) . "</p>";  ?>
                            <?php if ($productoAMostrar['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                        </div>
                    
                    </a>
                    <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 2) {
                        $productoAMostrar2 = $producto;
                        break;
                    }
                  }
                ?>
                    <a href="Descripcion.php?id=2" style="margin-right: 20px;">
                    <div class="Neglo">
                        <img class="a" src="https://th.bing.com/th/id/OIP.WpTuwYTS6IBQh2kLB1Wd2gHaIW?w=187&h=211&c=7&r=0&o=5&dpr=1.5&pid=1.7" alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar2['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar2['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar2['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                    </div>
                    </a>
                    <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 3) {
                        $productoAMostrar3 = $producto;
                        break;
                    }
                  }
                ?>
                    <a href="Descripcion.php?id=3" style="margin-right: 20px;">
                    <div class="Neglo">
                        <img class="a" src="https://th.bing.com/th/id/OIP.PMmzXdJZhZVZ-UNi8GezYgHaHa?w=211&h=211&c=7&r=0&o=5&dpr=1.5&pid=1.7" alt="Producto 3">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar3['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar3['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar3['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                    </div>
                    </a>
                    <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 4) {
                        $productoAMostrar4 = $producto;
                        break;
                    }
                  }
                ?>
                    <a href="Descripcion.php?id=4" style="margin-right: 20px;">
                    <div class="Neglo">
                        <img class="a" src="https://th.bing.com/th/id/OIP.YHyM78CbwmJqJQJ_wvYPjQHaHa?w=214&h=213&c=7&r=0&o=5&dpr=1.5&pid=1.7" alt="Producto 4">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar4['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar4['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar4['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                    </div>
                    </a>
                </div>
            <div class="columnas">
            <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 6) {
                        $productoAMostrar6 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=6" style="margin-right: 20px;">
                <div class="Neglo">
                    <img class="a"  src="https://th.bing.com/th/id/OIP.Hl13D9bzRamP15S9X_WnrQHaHa?w=214&h=213&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar6['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar6['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar6['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 5) {
                        $productoAMostrar5 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=5" style="margin-right: 20px;">
                    <div class="Neglo">
                        <img class="a"  src="https://th.bing.com/th/id/OIP.w1qFM5q4NbKAk_bhTkIjFgHaHa?w=196&h=195&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar5['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar5['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar5['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                    </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 7) {
                        $productoAMostrar7 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=7" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.VDmK5ZPbFe1Mp7aIUFkGRAHaHa?w=195&h=195&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar7['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar7['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar7['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 34) {
                        $productoAMostrar34 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=34" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.u4czzLsMbq8sbJoX1WGbDAHaJA?w=173&h=211&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar34['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar34['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar34['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
            </div>

            <h2>CAMISAS DEPORTIVAS DE MUJER A LA MODA</h2>
            <div class="columnas">
            <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 8) {
                        $productoAMostrar8 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=8" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.EjE0-ZaSsTxZl8lc3AygmQHaJa?w=203&h=258&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar8['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar8['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar8['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 9) {
                        $productoAMostrar9 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=9" style="margin-right: 20px;">
                <div class="Neglo">
                    <img class="a"  src="https://th.bing.com/th/id/OIP.eXmOwW4YA0mrLP16peYiWQHaJQ?w=203&h=254&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar9['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar9['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar9['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 10) {
                        $productoAMostrar10 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=10" style="margin-right: 20px;">
                <div class="Neglo">
                    <img class="a"  src="https://th.bing.com/th/id/OIP.OrAE30oA5eivoEnW5EszigHaJQ?w=203&h=254&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar10['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar10['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar10['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 11) {
                        $productoAMostrar11 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=11" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.w_isPvdAJ1CWP-7rGmOTzwHaJa?w=203&h=258&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar11['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar11['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar11['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
            </div>

            <div class="columnas">
            <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 12) {
                        $productoAMostrar12 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=12" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.iVh7IcWDlEK0nwB-Wm8hLwHaJa?w=203&h=258&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar12['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar12['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar12['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 13) {
                        $productoAMostrar13 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=13" style="margin-right: 20px;">
                <div class="Neglo">
                    <img class="a"  src="https://th.bing.com/th/id/OIP._d7T7bh8C7MKvc79DSepYQHaJa?w=203&h=258&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar13['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar13['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar13['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>  
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 14) {
                        $productoAMostrar14 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=14" style="margin-right: 20px;">
                <div class="Neglo">
                    <img class="a"  src="https://th.bing.com/th/id/OIP.bsAEv5Kg8yWSMGEfdgIXfQHaLE?w=203&h=303&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar14['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar14['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar14['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 15) {
                        $productoAMostrar15 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=15" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.7gANzxL_BHUsSKa-7mxwFQHaJQ?w=203&h=254&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar15['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar15['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar15['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
            </div>



            <h2>SHORTS DEPORTIVAS PARA MUJER</h2>
            <div class="columnas">
            <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 16) {
                        $productoAMostrar16 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=16" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.-7JalewLUEIPN-RViKWIawHaHa?w=215&h=215&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar16['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar16['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar16['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 17) {
                        $productoAMostrar17 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=17" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.w6PWXYxSzlFsNJxV7MTeaAHaJ4?w=161&h=215&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar17['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar17['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar17['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 18) {
                        $productoAMostrar18 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=18" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.40i9zaZeHEpiuG1oD90gJgHaJy?w=144&h=191&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar18['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar18['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar18['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 19) {
                        $productoAMostrar19 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=19" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.BgHh9PvU1EAe-akyXReiyQHaF8?w=249&h=198&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar19['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar19['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar19['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
            </div>
            <h2>SHORTS DEPORTIVAS PARA HOMBRE</h2>
            <div class="columnas">
            <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 20) {
                        $productoAMostrar20 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=20" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.48606MiVB1rYLpLGwti0sAHaJD?w=180&h=220&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar20['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar20['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar20['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 21) {
                        $productoAMostrar21 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=21" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.1N6zsM1_mKsQRso8lyGOdwHaHa?w=219&h=219&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar21['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar21['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar21['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 22) {
                        $productoAMostrar22 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=22" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.mT8Ild475mAkmZgn9w69NAHaHa?w=210&h=209&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar22['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar22['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar22['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 23) {
                        $productoAMostrar23 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=23" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.pkGEz-r-E1Kzk9HjQaGqAgHaJQ?w=176&h=219&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar23['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar23['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar23['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
            </div>


            <h2>TENIS DEPORTIVAS</h2>
            <div class="columnas">
            <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 25) {
                        $productoAMostrar25 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=25" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src=" https://th.bing.com/th/id/OIP.AQ6pLUoetFvuizXUN1iEUAHaF-?w=255&h=205&c=7&r=0&o=5&dpr=1.5&pid=1.7 "
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar25['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar25['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar25['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 26) {
                        $productoAMostrar26 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=26" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.zoR6Aj2QRXWEP3ysfbg6SgHaHa?w=181&h=181&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar26['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar26['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar26['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 27) {
                        $productoAMostrar27 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=27" style="margin-right: 20px;">
                <div class="Neglo">
                    <img class="a" src="https://th.bing.com/th/id/OIP.RaBBXgNOlR4d3hslAEosZQHaHa?w=192&h=191&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar27['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar27['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar27['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 28) {
                        $productoAMostrar28 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=28" style="margin-right: 20px;">
                <div class="Neglo">
                    <img class="a"  src="https://th.bing.com/th/id/OIP.s78CkToGVTWXEjmMHPpgLwHaHa?w=217&h=217&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar28['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar28['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar28['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
               
            </div>

            <div class="columnas">
            <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 30) {
                        $productoAMostrar30 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=30" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.2kshvMIdVr443i966BubqQHaHa?w=217&h=217&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar30['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar30['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar30['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 31) {
                        $productoAMostrar31 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=31" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.4kfivkq4E68h35JbMLZnvQHaHa?w=194&h=194&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar31['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar31['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar31['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 32) {
                        $productoAMostrar32 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=32" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.ckhRBewDhIt2LQvsHQ_0RAHaHa?w=194&h=194&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 1">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar32['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar32['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar32['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
                <?php
                  foreach ($productos as $producto) {
                    if ($producto['id'] == 33) {
                        $productoAMostrar33 = $producto;
                        break;
                    }
                  }
                ?>
                <a href="Descripcion.php?id=33" style="margin-right: 20px;">
                <div class="Neglo">
                    <img  class="a" src="https://th.bing.com/th/id/OIP.ij4MxC0fnpWGuVMnKmBMgwAAAA?w=187&h=194&c=7&r=0&o=5&dpr=1.5&pid=1.7"
                        alt="Producto 2">
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar33['nombre']) . "</p>";  ?>
                        <?php echo "<p>" . htmlspecialchars($productoAMostrar33['precio']) . "</p>";  ?>
                        <?php if ($productoAMostrar33['stock'] <= 0) echo "<p class='textoAgotado'>Agotado</p>"; ?>
                </div>
                </a>
            </div>


        </div>
    </main>
    <br><br><br><br><br>
    <footer>
        <p>Benito Juárez #52, Uriangato, México</p>
        <p>Tienda de Ropa Deportiva Shoppy-on</p>
        <br><br>
        <p>Correo de contacto <br>Shoppy-on@gmail.com</p>
        <p>Telefono de contacto <br> 444-214-1354</p>
        <br><br>
        <p>&copy; 2024 Todos los derechos reservados</p>
    </footer>
</body>

</html>