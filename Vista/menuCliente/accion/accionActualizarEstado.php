<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$controllerCompraEstadoTipo = new c_compraEstadoTipo();
if ($controllerCompraEstadoTipo->aceptarCompra($_POST['idCompra'])) {
    echo json_encode(array('success'=>1));
} else {
    echo json_encode(array('success'=>0));
}
?>