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
<title>Login</title>
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
        <h3>INICIA SESIÓN</h3>

    <?php if ($mensaje): ?>
            <div id="mensaje" class="mensaje <?php echo htmlspecialchars($tipoMensaje); ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

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
    </script>
        
        <form action="iniciarSesion.php" method="post">
            <div>
                <label>Correo</label>
                <input type="email" name="email" placeholder="Correo electronico" required autofocus maxlength="100">
            </div>
            <div>
                <label>Contraseña</label>
                <input type="password" name="contrasenia" placeholder="Password" required minlength="6" maxlength="8">
            </div>
            <div>
                <button type="submit">Iniciar Sesion</button>
            </div>
        </form>
        <form action="registro.php">
            <button type="submit">¿No tienes cuenta? Regístrate</button>
        </form>
    </div>
  </section>
</div>
