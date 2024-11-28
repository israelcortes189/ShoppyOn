<?php
require_once('Conexion.php');
require_once('DAOProducto.php');

class DAOCarrito {
    
    public static function registrarCarrito($idProducto, $nombre, $precioTotal, $cantidad, $idUsuario){
    $conexion = Conexion::conectar(); // Obtiene la conexión
    // Consulta SQL parametrizada para insertar en la tabla carrito
    $query = "INSERT INTO carrito (idproducto, nombre_producto, precio_total, cantidad, idusuario) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $query);
    if ($stmt === false) {
        // Manejo de error si la consulta no se prepara correctamente
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }
    // Asigna los valores de los parámetros a la consulta
    mysqli_stmt_bind_param($stmt, "isdii", $idProducto, $nombre, $precioTotal, $cantidad, $idUsuario);
    // "i" = entero, "s" = string, "d" = double
    // Ejecuta la consulta
    $resultado = mysqli_stmt_execute($stmt);
    if ($resultado === false) {
        // Manejo de error si la consulta no se ejecuta correctamente
        throw new Exception("Error al ejecutar la consulta: " . mysqli_error($conexion));
    }
    // Cierra la declaración y la conexión
    mysqli_stmt_close($stmt);

    mysqli_close($conexion);
    return true; // Devuelve true si la inserción fue exitosa
}

public static function obtenerDatos($id)
{
    $conexion = Conexion::conectar(); // Obtiene la conexión
    // Consulta SQL parametrizada para obtener datos del carrito
    $query = "SELECT nombre_producto, precio_total, cantidad, idproducto FROM carrito WHERE idusuario = ?";
    $stmt = mysqli_prepare($conexion, $query);
    if ($stmt === false) {
        // Manejo de error si la consulta no se prepara correctamente
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }
    // Asigna el valor del parámetro a la consulta
    mysqli_stmt_bind_param($stmt, "i", $id); // "i" indica que es un valor entero
    // Ejecuta la consulta
    mysqli_stmt_execute($stmt);
    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);
    // Arreglo donde se almacenarán los datos del carrito
    $datosCarrito = [];
    // Itera sobre los resultados y almacena cada registro en el arreglo
    while ($row = mysqli_fetch_assoc($resultado)) {
        $datosCarrito[] = [
            'nombre_producto' => $row['nombre_producto'],
            'precio_total' => $row['precio_total'],
            'cantidad' => $row['cantidad'],
            'idproducto' => $row['idproducto']
        ];
    }
    // Cierra la declaración y la conexión
    mysqli_stmt_close($stmt);
    //mysqli_close($conexion);
    return $datosCarrito; // Devuelve los datos obtenidos
}

public static function obtenerProducto($idUsuario)
{
    $conexion = Conexion::conectar(); // Obtiene la conexión

    // Consulta SQL parametrizada para obtener productos del carrito de un usuario
    $query = "SELECT nombre_producto, cantidad, idproducto FROM carrito WHERE idusuario = ?";

    $stmt = mysqli_prepare($conexion, $query);
    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Vincula el parámetro del ID de usuario
    mysqli_stmt_bind_param($stmt, "i", $idUsuario);

    // Ejecuta la consulta
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

    // Arreglo para almacenar los productos del carrito
    $productos = [];

    // Itera sobre los resultados y almacena cada producto en el arreglo
    while ($row = mysqli_fetch_assoc($resultado)) {
        $productos[] = [
            'nombre_producto' => $row['nombre_producto'],
            'cantidad' => $row['cantidad'],
            'idproducto' => $row['idproducto']
        ];
    }

    // Cierra la declaración
    mysqli_stmt_close($stmt);

    // Opcional: Cierra la conexión si no se reutiliza más adelante
    // mysqli_close($conexion);

    return $productos; // Devuelve el arreglo con los productos del carrito
}
 

public static function sumaTotal($id)
{
    $conexion = Conexion::conectar(); // Obtiene la conexión
    
    // Consulta SQL parametrizada para obtener la suma total de los productos del carrito
    $query = "SELECT SUM(precio_total) AS total FROM carrito WHERE idusuario = ?";
    
    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt === false) {
        // Manejo de error si la consulta no se prepara correctamente
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Asigna el valor del parámetro a la consulta
    mysqli_stmt_bind_param($stmt, "i", $id); // "i" indica que es un valor entero

    // Ejecuta la consulta
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

    // Verifica si se obtuvo algún resultado
    if ($row = mysqli_fetch_assoc($resultado)) {
        // Devuelve el total obtenido
        $total = $row['total'];
    } else {
        // Si no se encuentra ningún resultado, el total es 0
        $total = 0;
    }

    // Cierra la declaración y la conexión
    mysqli_stmt_close($stmt);
    //mysqli_close($conexion);

    return $total; // Devuelve el total calculado
}
    
public static function eliminarCarrito($idUsuario)
{
    $conexion = Conexion::conectar(); // Obtiene la conexión

    // Consulta SQL parametrizada para eliminar todos los productos del carrito de un usuario específico
    $query = "DELETE FROM carrito WHERE idusuario = ?";

    $stmt = mysqli_prepare($conexion, $query);
    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Asigna los valores de los parámetros
    mysqli_stmt_bind_param($stmt, "i", $idUsuario);

    // Ejecuta la consulta
    $resultado = mysqli_stmt_execute($stmt);

    // Verifica si la consulta se ejecutó correctamente
    if ($resultado === false) {
        throw new Exception("Error al eliminar el carrito: " . mysqli_stmt_error($stmt));
    }

    // Cierra la declaración
    mysqli_stmt_close($stmt);

    // Opcional: Cierra la conexión si no se reutiliza más adelante
    // mysqli_close($conexion);

    return $resultado; // Devuelve true si la eliminación fue exitosa
}
    
    
    public static function eliminarProductoDelCarrito($idProducto, $idUsuario)
{
    $conexion = Conexion::conectar(); // Obtiene la conexión

    // Consulta SQL parametrizada para eliminar el producto del carrito
    $query = "DELETE FROM carrito WHERE idproducto = ? AND idusuario = ?";

    $stmt = mysqli_prepare($conexion, $query);
    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Asigna los valores de los parámetros
    mysqli_stmt_bind_param($stmt, "ii", $idProducto, $idUsuario);

    // Ejecuta la consulta
    $resultado = mysqli_stmt_execute($stmt);

    // Verifica si la consulta se ejecutó correctamente
    if ($resultado === false) {
        throw new Exception("Error al eliminar el producto del carrito: " . mysqli_stmt_error($stmt));
    }

    // Cierra la declaración
    mysqli_stmt_close($stmt);

    // Opcional: Cierra la conexión si no se reutiliza más adelante
    // mysqli_close($conexion);

    return $resultado; // Devuelve true si la eliminación fue exitosa
}

    
/*
    public function actualizarCarrito($idProducto, $cantidad, $precioTotal, $idUsuario) {
        try {
            $sql = "UPDATE carrito 
                    SET cantidad = :cantidad, precio_total = :precioTotal 
                    WHERE idproducto = :idProducto AND idusuario = :idUsuario";
    
            $stmt = $this->conexion->prepare($sql);
    
            $stmt->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':precioTotal', $precioTotal, PDO::PARAM_STR);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                return true;
            } else {
                echo "Error: No se pudo ejecutar la consulta.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
*/
}
?>
