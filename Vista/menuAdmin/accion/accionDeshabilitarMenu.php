<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$objMenu = new c_menu();
if ($objMenu->baja($datos)) {
    echo json_encode(array('success'=>1));
} else {
    echo json_encode(array('success'=>0));
}
?>