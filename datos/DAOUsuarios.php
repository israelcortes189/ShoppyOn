<?php
require_once 'Conexion.php';
require_once 'modelos/usuario.php';

class DAOUsuarios{
    
    public static function registrarUsuario(Usuario $usuario)
    {
        $contraseniaHash = password_hash($usuario->contrasenia, PASSWORD_DEFAULT);
        $conexion = Conexion::conectar();  // Obtiene la conexión
        // Consulta SQL preparada
        $query = "INSERT INTO usuarios (nombre, correo, contrasenia, telefono, direccion) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $query);
        if ($stmt === false) {
            throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
        }
        // Vincula parámetros (s: string) usando las propiedades del objeto Usuario
        mysqli_stmt_bind_param(
            $stmt, 
            "sssss", 
            $usuario->nombre, 
            $usuario->correo, 
            $contraseniaHash, 
            $usuario->telefono, 
            $usuario->direccion
        );
        // Ejecuta la consulta
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error al insertar el usuario: " . mysqli_stmt_error($stmt));
        }
        // Cierra la consulta preparada
        mysqli_stmt_close($stmt);
        return true;  // Inserción exitosa
    }
    public static function autenticar($correo, $contrasenia)
    {
        $conexion = Conexion::conectar();  // Obtiene la conexión
        // Consulta SQL para obtener los detalles del usuario por correo
        $query = "SELECT id, nombre, correo, contrasenia FROM usuarios WHERE correo = ?";
        $stmt = mysqli_prepare($conexion, $query);
        if ($stmt === false) {
            throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
        }
        // Vincula el parámetro del correo
        mysqli_stmt_bind_param($stmt, "s", $correo);
        // Ejecuta la consulta
        mysqli_stmt_execute($stmt);
        // Obtiene el resultado de la consulta
        $resultado = mysqli_stmt_get_result($stmt);
        // Si el usuario existe
        if ($usuario = mysqli_fetch_assoc($resultado)) {
            // Verifica la contraseña ingresada con la almacenada (encriptada)
            if (password_verify($contrasenia, $usuario['contrasenia'])) {
                // Devuelve los datos del usuario si las credenciales son correctas
                return $usuario;
            } else {
            }
        } else {
            // El correo no se encuentra en la base de datos
            throw new Exception("Usuario no encontrado.");
        }
        // Cierra la consulta preparada
        mysqli_stmt_close($stmt);
    }

    public static function correoExiste($correo)
    {
        $conexion = Conexion::conectar();  // Obtiene la conexión

        // Consulta SQL para contar cuántos usuarios tienen ese correo
        $query = "SELECT COUNT(*) AS total FROM usuarios WHERE correo = ?";
        $stmt = mysqli_prepare($conexion, $query);

        if ($stmt === false) {
            // Manejo de error si la consulta no se prepara correctamente
            throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
        }

        // Vincula el parámetro del correo
        mysqli_stmt_bind_param($stmt, "s", $correo);

        // Ejecuta la consulta
        mysqli_stmt_execute($stmt);

        // Obtiene el resultado de la consulta
        $resultado = mysqli_stmt_get_result($stmt);

        // Extrae el valor de la columna total
        $existe = false;  // Por defecto, se asume que el correo no existe
        if ($row = mysqli_fetch_assoc($resultado)) {
            // Si se encuentra el correo, existe al menos un usuario con ese correo
            $existe = $row['total'] > 0;
        }
        // Cierra la sentencia preparada
        mysqli_stmt_close($stmt);
        return $existe;
    }

    public static function obtenerUsuarioPorId($id)
    {
        $conexion = Conexion::conectar();  // Obtiene la conexión

        // Consulta SQL para obtener los datos del usuario por su ID
        $query = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $query);

        if ($stmt === false) {
            // Manejo de error si la consulta no se prepara correctamente
            throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
        }

        // Vincula el parámetro del ID
        mysqli_stmt_bind_param($stmt, "i", $id);  // "i" indica que el parámetro es un entero

        // Ejecuta la consulta
        mysqli_stmt_execute($stmt);

        // Obtiene el resultado de la consulta
        $resultado = mysqli_stmt_get_result($stmt);

        // Si se encuentra un usuario con ese ID, almacena los datos en un arreglo
        $usuarioArray = null;
        if ($row = mysqli_fetch_assoc($resultado)) {
            $usuarioArray = [
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'correo' => $row['correo'],
                'contrasenia' => $row['contrasenia'],
                'telefono' => $row['telefono'],
                'direccion' => $row['direccion'],
                'activo'=> $row['activo']
            ];
        }
        // Cierra la sentencia preparada
        mysqli_stmt_close($stmt);
        return $usuarioArray;
    }

    public static function obtenerUsuarios()
    {
        $conexion = Conexion::conectar();  // Obtiene la conexión
        // Consulta SQL para obtener usuarios activos (excluyendo el id 1)
        $query = "SELECT id, nombre, correo, telefono, direccion FROM usuarios WHERE activo = TRUE AND id != 1";
        $resultados = mysqli_query($conexion, $query);
        if (!$resultados) {
            // Manejo de error si la consulta no se ejecuta correctamente
            throw new Exception("Error al ejecutar la consulta: " . mysqli_error($conexion));
        }
        $usuarios = [];  // Array para almacenar los resultados
        // Recorremos los resultados y los almacenamos en el array
        while ($row = mysqli_fetch_assoc($resultados)) {
            // Cada fila es un usuario, creamos un arreglo de usuarios
            $usuarios[] = $row;
        }
        // Cierra el resultado de la consulta
        mysqli_free_result($resultados);
        // Retorna el arreglo de usuarios
        return $usuarios;
    }
    

    public static function actualizarUsuario($id, $nombre, $correo, $telefono, $direccion)
{
    $conexion = Conexion::conectar(); // Obtiene la conexión

    // Prepara la consulta parametrizada
    $query = "UPDATE usuarios SET nombre = ?, correo = ?, telefono = ?, direccion = ? WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Vincula los parámetros de entrada
    mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $correo, $telefono, $direccion, $id);

    // Ejecuta la consulta
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al actualizar el usuario con ID $id: " . mysqli_stmt_error($stmt));
    }else{
        return true;
    }
    // Cierra la declaración
    mysqli_stmt_close($stmt);

    // Opcional: Cierra la conexión si no se reutiliza más adelante
    // mysqli_close($conexion);
}
    
public static function inactivarUsuario($id)
{
    $conexion = Conexion::conectar(); // Obtiene la conexión

    // Prepara la consulta parametrizada
    $query = "UPDATE usuarios SET activo = FALSE WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Vincula el parámetro de entrada
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Ejecuta la consulta
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al inactivar el usuario con ID $id: " . mysqli_stmt_error($stmt));
    }

    // Cierra la declaración
    mysqli_stmt_close($stmt);

    // Opcional: Cierra la conexión si no se reutiliza más adelante
    // mysqli_close($conexion);
}

}
?>
