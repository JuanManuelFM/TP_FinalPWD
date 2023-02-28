<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$objSession = new c_session();
if ($objSession->validar($datos)) {
    echo json_encode(array('success'=>1));
} else {
    echo json_encode(array('success'=>0));
}
