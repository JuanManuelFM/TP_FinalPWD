<?php
include_once("../../../configuracion.php");

$datos = data_submitted();
$objPersona = new c_usuario();
$objUsuario = $objPersona->buscar(["usNombre" => $datos["usNombre"]]); // Busca el usuario con el nombre
if($objUsuario == null){
    if ($objPersona->alta($datos)) {
        echo json_encode(array('success'=>1));
    } else {
        echo json_encode(array('success'=>0));
    }
}else{
    //Existe ya el usuario
    echo json_encode(["success" => 0]);
    exit; //deja de ejecutar en adelante
}
