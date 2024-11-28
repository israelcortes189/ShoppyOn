<?php
require_once 'datos/DAOUsuarios.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["contrasenia"])) {
        $email = $_POST["email"];
        $contrasenia = $_POST["contrasenia"];

        $daoUsuario = new DAOUsuarios();
        $usuario = $daoUsuario->autenticar($email, $contrasenia);
        $email = $daoUsuario->correoExiste($email);
              
        if ($usuario) {
            $_SESSION["usuario"] = $usuario;
            $_SESSION["user_id"] = $usuario['id'];
            header("Location: index.php");
            exit();
        } else if($email){
            $_SESSION['mensaje'] = "La contraseña es incorrecta.";
            $_SESSION['tipo'] = "error"; 
            header("Location: login.php");
            exit();
        } else if(($email === false)){
            $_SESSION['mensaje'] = "Correo no registrado.";
            $_SESSION['tipo'] = "error"; 
            header("Location: login.php");
            exit();
        } 
    } else {
        header("Location: login.php?mensaje=" . urlencode("Faltan datos del formulario."));
        exit();
    }
} else {
    header("Location: login.php?mensaje=" . urlencode("Método no permitido. Debes enviar una solicitud POST."));
    exit();
}
?>
