<?php
require_once('Conexion.php');

class DAOProducto {
    
    public static function obtenerProductoPorId($id)
{
    $conexion = Conexion::conectar();  // Obtiene la conexión
    // Consulta SQL parametrizada para obtener un producto por su ID
    $query = "SELECT * FROM productos WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt === false) {
        // Manejo de error si la consulta no se prepara correctamente
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Asigna el valor del parámetro a la consulta
    mysqli_stmt_bind_param($stmt, "i", $id); // "i" indica que el parámetro es un entero

    // Ejecuta la consulta
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

    // Verifica si se encontró algún producto
    if ($row = mysqli_fetch_assoc($resultado)) {
        // Devuelve el producto como un arreglo asociativo
        return [
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'descripcion' => $row['descripcion'],
            'precio' => $row['precio'],
            'stock' => $row['stock']
        ];
    } else {
        // Si no se encuentra el producto, devuelve null o lanza una excepción
        return null;
    }
}

public static function obtenerImagen($id)
{
    $conexion = Conexion::conectar();  // Obtiene la conexión
    // Consulta SQL parametrizada para obtener la imagen por ID
    $query = "SELECT imagen FROM productos WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt === false) {
        // Manejo de error si la consulta no se prepara correctamente
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Asigna el valor del parámetro a la consulta
    mysqli_stmt_bind_param($stmt, "i", $id); // "i" indica que el parámetro es un entero

    // Ejecuta la consulta
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

    // Verifica si se encontró la imagen
    if ($row = mysqli_fetch_assoc($resultado)) {
        // Devuelve la imagen
        return $row['imagen'];
    } else {
        // Si no se encuentra la imagen, devuelve null o lanza una excepción
        return null;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
}

public static function obtenerImagenPorNombre($nombre)
{
    // Crear una nueva conexión
    $conexion = mysqli_init();

    // Configuración SSL
    mysqli_ssl_set($conexion, null, null, __DIR__ . '/../certs/ca-cert.pem', null, null);

    // Intento de conexión
    if (!mysqli_real_connect(
        $conexion,
        's20120189.mysql.database.azure.com',
        's20120189',
        'Ortiz123#',
        'tienda',
        3306,
        null,
        MYSQLI_CLIENT_SSL  // Especifica el uso de SSL aquí
    )) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }

    // Establecer la codificación de caracteres a UTF-8
    mysqli_set_charset($conexion, "utf8");

    $query = "SELECT imagen FROM productos WHERE nombre = ?";
    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "s", $nombre);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    $imagen = null;
    if ($row = mysqli_fetch_assoc($resultado)) {
        $imagen = $row['imagen'];
    }

    // Cierra la declaración y la conexión
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);

    return $imagen;
}


public static function obtenerCantidad($id)
{
    $conexion = Conexion::conectar(); // Obtiene la conexión

    // Consulta SQL parametrizada para obtener el stock de un producto
    $query = "SELECT stock FROM productos WHERE id = ?";

    $stmt = mysqli_prepare($conexion, $query);
    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Vincula el parámetro del ID del producto
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Ejecuta la consulta
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

    // Verifica si hay resultados
    if ($row = mysqli_fetch_assoc($resultado)) {
        // Devuelve el valor del stock
        return $row['stock'];
    } else {
        // En caso de no encontrar el producto
        throw new Exception("Producto no encontrado con el ID: " . $id);
    }

    // Cierra la declaración
    mysqli_stmt_close($stmt);

    // Opcional: Cierra la conexión si no se reutiliza más adelante
    // mysqli_close($conexion);
}

public static function actualizarCantidades($productos)
{
    $conexion = Conexion::conectar(); // Obtiene la conexión

    // Prepara la consulta de actualización
    $query = "UPDATE productos SET stock = ? WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Itera sobre cada producto en el listado
    foreach ($productos as $producto) {
        $stock = $producto['cantidad'];
        $id = $producto['idProducto'];

        // Vincula los parámetros para cada producto
        mysqli_stmt_bind_param($stmt, "ii", $stock, $id);

        // Ejecuta la consulta para cada producto
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error al actualizar el producto con ID $id: " . mysqli_stmt_error($stmt));
        }
    }

    // Cierra la declaración
    mysqli_stmt_close($stmt);

    // Opcional: Cierra la conexión si no se reutiliza más adelante
    // mysqli_close($conexion);
}


    public static function obtenerTodosLosProductos()
    {
        $conexion = Conexion::conectar();  // Obtiene la conexión
        // Consulta SQL para obtener todos los productos
        $query = "SELECT * FROM productos";
        $stmt = mysqli_prepare($conexion, $query);
        if ($stmt === false) {
            // Manejo de error si la consulta no se prepara correctamente
            throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
        }
        // Ejecuta la consulta
        mysqli_stmt_execute($stmt);
        // Obtiene el resultado de la consulta
        $resultado = mysqli_stmt_get_result($stmt);
        // Arreglo donde se almacenarán todos los productos
        $productos = [];
        // Itera sobre los resultados y almacena cada producto en el arreglo
        while ($row = mysqli_fetch_assoc($resultado)) {
            $productos[] = [
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'descripcion' => $row['descripcion'],
                'precio' => $row['precio'],
                'stock' => $row['stock']
            ];
        }

        // Cierra la sentencia preparada
        mysqli_stmt_close($stmt);

        return $productos;  // Retorna el arreglo con todos los productos
    }

    public static function actualizarProductoPorId($id, $nombre, $descripcion, $precio, $stock)
    {
        $conexion = Conexion::conectar(); // Obtiene la conexión
        // Consulta SQL parametrizada para actualizar el producto
        $query = "UPDATE productos 
                  SET nombre = ?, 
                      descripcion = ?, 
                      precio = ?, 
                      stock = ? 
                  WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $query);
        if ($stmt === false) {
            throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
        }
    
        // Asigna los valores de los parámetros
        mysqli_stmt_bind_param($stmt, "ssdii", $nombre, $descripcion, $precio, $stock, $id);
    
        // Ejecuta la consulta
        $resultado = mysqli_stmt_execute($stmt);
    
        // Verifica si la consulta se ejecutó correctamente
        if ($resultado === false) {
            throw new Exception("Error al actualizar el producto: " . mysqli_stmt_error($stmt));
        }
    
        // Cierra la declaración
        mysqli_stmt_close($stmt);
        
        // Opcional: Cierra la conexión si no se reutiliza más adelante
        // mysqli_close($conexion);
        
        return $resultado; // Devuelve true si la actualización fue exitosa
    }
    

    public static function vaciarProducto($id)
    {
        $conexion = Conexion::conectar(); // Obtiene la conexión
    
        // Prepara la consulta parametrizada
        $query = "UPDATE productos SET stock = 0 WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $query);
    
        if ($stmt === false) {
            throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
        }
    
        // Vincula el parámetro de entrada
        mysqli_stmt_bind_param($stmt, "i", $id);
    
        // Ejecuta la consulta
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error al vaciar el stock del producto con ID $id: " . mysqli_stmt_error($stmt));
        }
    
        // Cierra la declaración
        mysqli_stmt_close($stmt);
    
        // Opcional: Cierra la conexión si no se reutiliza más adelante
        // mysqli_close($conexion);
    }    
}

?>
