<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$controllerRol = new c_rol();
// $objMenu = $controllerRol->buscar(["rolDescripcion" => $datos["rolDescripcion"]]); // Busca el menu con el nombre
if ($controllerRol->alta([...$datos, 'meDeshabilitado' => null])) {
    $lastRol = $controllerRol->buscar([]);
    $lastRol = $lastRol[count($lastRol) - 1];
    echo json_encode(array('success' => 1));   
} else {
    echo json_encode(array('success' => 0));
}
