<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$controllerCompra = new c_compra();
$controllerCompraEstado = new c_compraEstado();

$arrayComprasEstado = $controllerCompraEstado->buscar($datos);
//adaptarlo para que guarde el estado de enviado en la compra
$arrayEstado = $controllerCompraEstadoTipo->buscar(['idCompraEstadoTipo' => $arrayComprasEstado[0]->getObjCompraEstadoTipo()->getIdCompraEstadoTipo()]);

$objCompraEstado = $controllerCompraEstado->listar($datos);


$datos = array_merge($datos, ['idCompraEstado'=> 3]);
if ($objCompraEstado[0]->modificacion($datos)) {
    echo json_encode(array('success'=>1));
} else {
    echo json_encode(array('success'=>0));
}
?>