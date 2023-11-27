<?php

$datos = $_POST;

$idCompraItem = $datos['idCompraItem'];
$compraItemController = new c_compraItem();


$objCompraItem = $compraItemController->buscar(['idCompraItem' => $idCompraItem])[0];

/* aca devuelvo el stock a producto jeje */
$idProducto = $objCompraItem->getObjProducto()->getIdProducto();
$cantidadActualCompraItem = $objCompraItem->getCiCantidad();//este es la cantidad actual de este compra item y la que se tiene que devolver


/*ahora le sumo la cantidad al producto */
$objProducto = new Producto();
$objProducto->buscar(intval($idProducto));
$cantNueva = intval($objProducto->getProCantStock()) + intval($cantidadActualCompraItem);
$objProducto->setProCantStock($cantNueva);//le seteo la nueva cantidad jeje

/* elimina y modifico jeje */
if(!$objCompraItem->eliminar()) {
    echo json_encode(['success' => 0, 'message' => "Error al eliminar"]);
    exit;
}

if(!$objProducto->modificar()) {
    echo json_encode(['success' => 0, 'message' => "Error al eliminar"]);
    exit;
}

echo json_encode(array('success' => 1, 'message' => "Producto eliminado"));
