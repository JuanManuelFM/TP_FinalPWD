<?php
include_once('../../../configuracion.php');
$objSession=new C_Session();
$sesionCerrada=$objSession->cerrar();
echo json_encode(array('success'=>1));
