<?php
require_once("datos/DAOUsuarios.php");
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
$idUsuario = $_GET['id'];
$daoUsuarios = new DAOUsuarios();
$usuario = $daoUsuarios->obtenerUsuarioporId($idUsuario);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="barra">
<a href="Usuarios.php">Volver</a>
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
        <h2>Editar Usuario</h2>
        <form id="editarUsuario" action="actualizarUsuario.php" method="post">
            <!-- onsubmit="return validarFormularioEditar()-->
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required autofocus minlength="3" maxlength="30">
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required autofocus maxlength="100">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required pattern="[0-9]{10}" minlength="10" maxlength="10">
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>" required maxlength="100">
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
        const form = document.getElementById('editarUsuario');

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

        function validarFormularioEditar() {
            var nombre = document.getElementById('nombre').value;
            var correo = document.getElementById('correo').value;
            var telefono = document.getElementById('telefono').value;
            var direccion = document.getElementById('direccion').value;
            var errorMensaje = document.getElementById('errorMensaje');

            if (nombre.length < 3 || nombre.length > 30) {
                errorMensaje.textContent = "El nombre debe tener entre 3 y 30 caracteres.";
                return false;
            }

            var correoExpresion = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!correo.match(correoExpresion)) {
                errorMensaje.textContent = "El correo no tiene un formato válido.";
                return false;
            }

            var telefonoExpresion = /^[0-9]{10}$/;
            if (!telefono.match(telefonoExpresion)) {
                errorMensaje.textContent = "El teléfono debe tener 10 dígitos numéricos.";
                return false;
            }

            if (direccion.length > 100) {
                errorMensaje.textContent = "La dirección no puede tener más de 100 caracteres.";
                return false;
            }

            errorMensaje.textContent = "";
            return true;


        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
