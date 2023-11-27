<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$objRol = new c_rol();
if ($objRol->modificacion($datos)) {
    echo json_encode(array('success'=>1));
} else {
    echo json_encode(array('success'=>0));
}
?>