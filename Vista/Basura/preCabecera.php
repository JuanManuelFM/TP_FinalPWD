<?php
$objSession= new c_session();
if ($objSession->getUsNombre() <> null){
    require_once('cabeceraSegura.php');
}else{
    require_once('cabecera.php');
}
?>

