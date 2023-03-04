<?php
include_once("../../configuracion.php");
$datos = data_submitted();
$objRol = new C_Rol();
$objSession = new C_Session();
$objRolVista = $objRol->obtenerObj($datos);
if(count($objRolVista) > 0){
    $objSession->setVista($objRolVista[0]->getIdRol());
    echo json_encode(array('success'=>1));
}else{
    echo json_encode(array('success'=>0));
}
?>