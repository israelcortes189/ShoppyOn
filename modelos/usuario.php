<?php
class Usuario {
    public $id = 0;
    public $nombre = "";
    public $correo = "";
    public $contrasenia = "";
    public $telefono= 0;
    public $direccion ="";

    public function __construct($nombre, $correo, $contrasenia, $telefono, $direccion) {
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->contrasenia = $contrasenia;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
    }
}
?>
