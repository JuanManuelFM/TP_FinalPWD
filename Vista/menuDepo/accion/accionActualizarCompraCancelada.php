<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$controllerCompra = new c_compra();
$controllerCompraEstado = new c_compraEstado();
$objCompraEstado = $controllerCompraEstado->listar($datos);
$datos = array_merge($datos, ['idCompraEstado'=> 4]);
if ($objCompraEstado[0]->modificacion($datos)) {
    echo json_encode(array('success'=>1));
} else {
    echo json_encode(array('success'=>0));
}
?>