<?php
session_start();
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;
$tipoMensaje = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : null;

unset($_SESSION['mensaje'], $_SESSION['tipo']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro</title>
<link rel="stylesheet" href="css/loging.css">
<style>
    .login-content form div {
        display: flex;
        flex-direction: column;
    }
    input[type="email"],
    input[type="password"],
    input[type="tel"],
    input[type="text"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
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
</style>
</head>
<body>
<div class="background">
  <section class="login-content">
    <div class="login-box">
        <h2>REGÍSTRATE</h2>

        <?php if ($mensaje): ?>
            <div class="mensaje <?php echo htmlspecialchars($tipoMensaje); ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <form name="registroForm" action="registrarUsuario.php" method="post" onsubmit="return validarFormulario()">
            <div>
                <label>Nombre</label>
                <input type="text" name="nombre" placeholder="Nombre" required autofocus minlength="3" maxlength="30">
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" placeholder="Email" required autofocus maxlength="100">
            </div>
            <div>
                <label>Teléfono</label>
                <input type="tel" name="telefono" placeholder="Teléfono" required pattern="[0-9]{10}" minlength="10" maxlength="10">
            </div>
            <div>
                <label>Dirección</label>
                <input type="text" name="direccion" placeholder="Dirección" required maxlength="100">
            </div>
            <div>
                <label>Contraseña</label>
                <input type="password" name="contrasenia" placeholder="Contraseña" required minlength="6" maxlength="8">
            </div>
            <div class="error-mensaje" id="errorMensaje"></div>
            <div>
                <button type="submit">Registrarse</button><br>
                <button type="button" onclick="window.location.href='login.php'">Regresar</button>
            </div>
        </form>
    </div>
  </section>
</div>

<script>
    function validarFormulario() {
        var form = document.forms["registroForm"];
        var nombre = form["nombre"].value;
        var email = form["email"].value;
        var telefono = form["telefono"].value;
        var direccion = form["direccion"].value;
        var contrasenia = form["contrasenia"].value;
        var errorMensaje = document.getElementById("errorMensaje");

        if (nombre.length < 3 || nombre.length > 30) {
            errorMensaje.innerText = "El nombre debe tener entre 3 y 30 caracteres.";
            return false;
        }

        var CorreoExpresion = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!email.match(CorreoExpresion)) {
            errorMensaje.innerText = "El correo no tiene un formato válido.";
            return false;
        }

        var telefonoExpresion = /^\d{10}$/;
        if (!telefono.match(telefonoExpresion)) {
            errorMensaje.innerText = "El teléfono debe tener 10 dígitos numéricos.";
            return false;
        }

        if (direccion.length > 100) {
            errorMensaje.innerText = "La dirección no puede tener más de 100 caracteres.";
            return false;
        }

        if (contrasenia.length < 6 || contrasenia.length > 8) {
            errorMensaje.innerText = "La contraseña debe tener entre 6 y 8 caracteres.";
            return false;
        }

        errorMensaje.innerText = "";
        return true;
    }
</script>

</body>
</html>
