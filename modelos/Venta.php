<?php
class Venta{
    public $id = 0;
    public $idProducto = 0;
    public $idUsuario = 0;
    public $precioTotal = 0.0;
    public $cantidad= 0;
    public $nombre="";

    public function __construct($idProducto, $idUsuario, $precioTotal, $cantidad, $nombre) {
        $this->idProducto = $idProducto;
        $this->idUsuario = $idUsuario;
        $this->precioTotal = $precioTotal;
        $this->cantidad = $cantidad;
        $this->nombre = $nombre;
    }
}
?>