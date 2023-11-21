<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
if($objSession->getVista() != null && $objSession->getVista() == 3) {
?>
<div>hola</div>
<?php
} else {
    header('Location: ../../index.php');
}
include_once("../menu/pie.php");
?>