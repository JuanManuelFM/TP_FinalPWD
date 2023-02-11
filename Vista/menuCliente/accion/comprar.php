<?php
include_once("../../../configuracion.php");

$datos = data_submitted();


$probando= new c_producto();
$objCompraItem= new CompraItem();


/* primero una forma de saber si ya tiene alguna compra iniciada */



$objProducto= new Producto();
$objProducto->buscar($datos['idProducto']);
$objCompra= new Compra();
$objCompra->buscar(1);
$objCompraItem->cargar(null, $objProducto, $objCompra, intval($datos["ciCantidad"]));
$objCompraItem->insertar();


$array= $probando->buscar($datos);



$nuevoValor= intval($array[0]->getProCantStock()) - intval($datos["ciCantidad"]);


$array[0]->setProCantStock($nuevoValor);



if (intval($datos["ciCantidad"] < intval($array[0]->getProCantStock()))) {
    echo json_encode(array('success'=>1));
} else {
$array[0]->modificar();
echo json_encode(array('success'=>0));


}









/*
    if ($objProducto->alta($datos)) {
        echo json_encode(array('success'=>1));
    } else {
        echo json_encode(array('success'=>0));
    } */
?>