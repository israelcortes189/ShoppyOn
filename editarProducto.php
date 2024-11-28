<?php
require_once("datos/DAOProducto.php");
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
$idProducto = $_GET['id'];
$daoProducto = new DAOProducto();
$producto = $daoProducto->obtenerProductoPorId($idProducto);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="barra">
<a href="productos.php">Volver</a>
    <ul>
        <form action="cerrarSesion.php" method="POST" id="fr">
           <button type="submit" id="btnCerrarSesion">Cerrar Sesión</button>
        </form>
    </ul>    
</div>
<style>
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
    .barra button{
        padding: 8px 15px;
        background-color: #555;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    a
    {
        padding: 8px 15px;
        background-color: burlywood;
        color: black;
        border: none;
        border-radius: 4px;
        cursor: pointer; 
        text-decoration: none;
    }

    .barra button:hover, a:hover {
        background-color: #444;
    }
    .error-mensaje {
        color: red;
    }

    
    .modal {
            display: none; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 300px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }

        .modal-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }
</style>
    <div class="container pt-4">
        <h2>Editar Producto</h2>
        <form id="editarProducto" action="actualizarProducto.php" method="post">
            <!-- onsubmit="return validarFormularioEditar()-->
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required autofocus minlength="3" maxlength="50">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($producto['descripcion']); ?>" required autofocus maxlength="150">
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required pattern="[0-9]{10}" minlength="10" maxlength="10">
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Cantidad disponible</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required maxlength="100">
            </div>
            <div class="error-mensaje" id="errorMensaje"></div>
            <button type="button" class="btn btn-primary" onclick="openModal()">Guardar</button>
        </form>

        <div id="confirmModal" class="modal">
                <div class="modal-content">
                    <p>¿Estás seguro de que deseas guardar los cambios?</p>
                    <div class="modal-buttons">
                        <button class="btn btn-danger" onclick="confirmUpdate()">Confirmar</button>
                        <button class="btn btn-cancel" onclick="closeModal()">Cancelar</button>
                    </div>
            </div>
        </div>
    </div>
    <script>
        const modal = document.getElementById('confirmModal');
        const form = document.getElementById('editarProducto');

        function openModal() {
            modal.style.display = 'block';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        function confirmUpdate() {
            closeModal();
            form.submit();
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
