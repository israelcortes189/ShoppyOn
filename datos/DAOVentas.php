<?php
require_once 'Conexion.php';
require_once 'modelos/Venta.php';

class DAOVentas {
    public static function registrarVenta($idUsuario, $precioTotal)
{
    $conexion = Conexion::conectar(); // Obtiene la conexión

    // Consulta SQL parametrizada para insertar una nueva venta
    $query = "INSERT INTO Ventas(idusuario, preciototal) VALUES (?, ?)";

    $stmt = mysqli_prepare($conexion, $query);
    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Asigna los valores de los parámetros
    mysqli_stmt_bind_param($stmt, "id", $idUsuario, $precioTotal);

    // Ejecuta la consulta
    $resultado = mysqli_stmt_execute($stmt);

    // Verifica si la consulta se ejecutó correctamente
    if ($resultado === false) {
        throw new Exception("Error al registrar la venta: " . mysqli_stmt_error($stmt));
    }

    // Cierra la declaración
    mysqli_stmt_close($stmt);

    // Opcional: Cierra la conexión si no se reutiliza más adelante
    // mysqli_close($conexion);

    return true; // Devuelve true si la inserción fue exitosa
}

/*
    public function obtenerDatosCompras($id) {
        try {
            $sql = "SELECT * FROM ventas WHERE idusuario = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $venta = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($venta) {
                return $venta;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Error en obtener datos: " . $e->getMessage());
            return null;
        } finally {
            Conexion::desconectar();
        }
    }
*/
}
?>

