<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$controllerMenu = new c_menu();
$objMenu = $controllerMenu->buscar(["meNombre" => $datos["meNombre"]]); // Busca el menu con el nombre
if($objMenu == null){
    if ($controllerMenu->alta($datos)) {
        echo json_encode(array('success'=>1));
    } else {
        echo json_encode(array('success'=>0));
    }
}else{
    //Existe ya el menu
    echo json_encode(["success" => 0]);
    exit; //deja de ejecutar en adelante
}