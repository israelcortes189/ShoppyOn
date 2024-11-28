<?php
session_start();
require_once 'datos/DAOUsuarios.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$usuarioSesion = $_SESSION['usuario'];
$idUsuario= $usuarioSesion['id'];

$daoUsuarios= new DAOUsuarios();
$usuario=$daoUsuarios->obtenerUsuarioporId($idUsuario);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Usuario</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/perfil.css">
</head>
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

        .container {
            max-width: 800px;
            margin: 0 auto;
            margin-left: 30;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            background-color: #333;
            color: white;
            padding: 10px;
            border-radius: 8px;
            display: inline-block;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"] {
            padding: 6px;
            margin-top: 8px;
            margin-right: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"],
        button[type="reset"] {
            padding: 8px 15px;
            background-color: #555;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover,
        button[type="reset"]:hover {
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
    </style>
<body>
    <div class="barra">
        <ul>
            <li><a href="index.php" id="nombreTienda">SHOOPY-ON</a></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="Usuarios.php">Perfil</a></li>
            <li><a href="carrito.php">Carrito</a></li>
            <form action="cerrarSesion.php" method="POST" id="fr">
               <button type="submit" id="btnCerrarSesion">Cerrar Sesión</button>
            </form>
        </ul>      
    </div>

    <div class="container" style="background-color: #b5abab; padding: 30px; box-sizing: border-box;">
       
        <div class="row">
            <div class="col-sm-8" style="margin-top: 50px;">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Perfil del Usuario</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="home">
                        <hr>
                        <form class="form" method="post" id="registrationForm">
                            <div class="formularioPago">
                                <div class="col-xs-6">
                                    <label for="nombre">
                                        <h4>Usuario</h4>
                                    </label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" placeholder="Nombre de usuario" readonly>
                                </div>
                            </div>
                            <div class="formularioPago">
                                <div class="col-xs-6">
                                    <label for="email">
                                        <h4>Correo</h4>
                                    </label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($usuario['correo']); ?>" placeholder="correo@email.com" readonly>
                                </div>
                            </div>
                            <div class="formularioPago">
                                <div class="col-xs-6">
                                    <label for="telefono">
                                        <h4>Telefono</h4>
                                    </label>
                                    <input type="number" class="form-control" name="telefono" id="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" placeholder="Telefono" readonly>
                                </div>
                            </div>
                            <div class="formularioPago">
                                <div class="col-xs-6">
                                    <label for="dirreccion">
                                        <h4>Direccion</h4>
                                    </label>
                                    <input type="text" class="form-control" name="direccion" id="direccion"  value="<?php echo htmlspecialchars($usuario['direccion']); ?>" placeholder="Direccion" readonly>
                                </div>
                            </div>

                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
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