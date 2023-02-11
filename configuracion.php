<?php header('Content-Type: text/html; charset=utf-8');
header ("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO ='PW/tp_final_pwd'; //Pone la ubicación de todo el proyecto desde htdocs del XAMP
//$PROYECTO ='PW/tp_final_pwd'; //a mi no me anduvo usa el otro jejejjejejejssjsjrsje




//variable que almacena el directorio del proyecto
$ROOT =$_SERVER['DOCUMENT_ROOT']."/$PROYECTO/"; //Agarra la ubicación del servidor donde tiene guardada la carpeta

include_once('util/funciones.php'); //Trae las funciones del script funciones.php



// Variable que define la pagina de autenticacion del proyecto
$INICIO = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/vista/login/login.php";

// variable que define la pagina principal del proyecto (menu principal)
$PRINCIPAL = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/principal.php";


$GLOBALS['ROOT']=$ROOT; 


?>