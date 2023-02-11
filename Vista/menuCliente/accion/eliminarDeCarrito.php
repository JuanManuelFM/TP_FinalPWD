<?php

$datos= data_submitted();

$idCompraItem= $datos['idCompraItem'];

$objCompraItem= new CompraItem();

$objCompraItem->buscar(intval('idCompraItem'));

/* aca devuelvo el stock a producto jeje */
$idProducto= $objCompraItem->getObjProducto()->getIdProducto();
$cantidadActualCompraItem= $objCompraItem->getCiCantidad();//este es la cantidad actual de este compra item y la que se tiene que devolver


/*ahora le sumo la cantidadal producto */ 
$objProducto= new Producto();
$objProducto->buscar(intval($idProducto));
$cantNueva= intval($objProducto->getProCantStock()) + intval($cantidadActualCompraItem);

$objProducto->setProCantStock($cantNueva);//le seteo la nueva cantidad jeje

/* elimina y modifico jeje */
$objCompraItem->eliminar();
$objProducto->modificar();

echo json_encode(array('success'=>1));
?>