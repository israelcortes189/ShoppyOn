<?php
session_start();
require_once 'datos/DAOUsuarios.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="barra">
    <li><a href="usuarios.php">Usuarios</a></li>
    <li><a href="productos.php">Productos</a></li>
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

    a{
        color: white;   
        text-decoration: none;
    }
    .barra button, li {
        list-style-type: none;
        padding: 8px 15px;
        background-color: #555;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .barra button:hover, li:hover {
        background-color: #444;
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
    <h2>Lista de Usuarios</h2>
    <?php
     require_once("datos/DAOUsuarios.php");
        $daoUsuarios = new DAOUsuarios();
        $usuarios = $daoUsuarios->obtenerUsuarios();
    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['nombre']; ?></td>
                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                <td><?php echo htmlspecialchars($usuario['direccion']); ?></td>
                <td>
                    <a href="editarUsuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-primary">Editar</a>
                        <form action="eliminarUsuario.php" method="post" class="deleteForm" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                            <button type="button" class="btn btn-danger" onclick="openModal(this)">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
           
            <div id="confirmModal" class="modal">
                <div class="modal-content">
                    <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                    <div class="modal-buttons">
                        <button class="btn btn-danger" onclick="confirmDelete()">Confirmar</button>
                        <button class="btn btn-cancel" onclick="closeModal()">Cancelar</button>
                    </div>
                </div>
            </div>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
        let currentForm;  

        function openModal(button) {
            currentForm = button.closest('.deleteForm');
            document.getElementById('confirmModal').style.display = 'block';  
        }

        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none'; 
        }

        function confirmDelete() {
            if (currentForm) {
                currentForm.submit();
            }
            closeModal();
        }
</script>
</body>
</html>
