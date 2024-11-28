<?php
class Conexion
{
    private static $servidor = 's20120189.mysql.database.azure.com';
    private static $db = 'tienda';
    private static $usuario = 's20120189';
    private static $password = 'Ortiz123#';
    private static $conexion = null;

    public static function conectar()
    {
        if (self::$conexion == null) {
            self::$conexion = mysqli_init();

            // Configuración SSL
            mysqli_ssl_set(self::$conexion, null, null, __DIR__ . '/../certs/ca-cert.pem', null, null);

            // Intento de conexión
            if (!mysqli_real_connect(
                self::$conexion,
                self::$servidor,
                self::$usuario,
                self::$password,
                self::$db,
                3306,
                null,
                MYSQLI_CLIENT_SSL
            )) {
                // Lanzar excepción en lugar de usar die()
                throw new Exception("Error de conexión: " . mysqli_connect_error());
            }

            // Establecer la codificación de caracteres a UTF-8
            mysqli_set_charset(self::$conexion, "utf8");
        }
        return self::$conexion;
    }

    public static function desconectar()
    {
        if (self::$conexion != null) {
            mysqli_close(self::$conexion);
            self::$conexion = null;
        }
    }
}
?>