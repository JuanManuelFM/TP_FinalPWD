<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$controllerProducto = new c_producto();
$producto = $controllerProducto->buscar(["proNombre" => $datos["proNombre"]]); // Busca el producto con el nombre
if($producto == null){
    if ($controllerProducto->alta($datos)) {
        echo json_encode(array('success'=>1));
    } else {
        echo json_encode(array('success'=>0));
    }
}else{
    //Existe ya el usuario
    echo json_encode(["success" => 0]);
    exit; //deja de ejecutar en adelante
}