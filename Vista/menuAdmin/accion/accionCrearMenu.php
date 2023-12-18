<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$controllerMenu = new c_menu();
$controllerMenuRol = new c_menuRol();
// $objMenu = $controllerMenu->buscar(["meNombre" => $datos["meNombre"]]); // Busca el menu con el nombre
if ($controllerMenu->alta([...$datos, 'meDeshabilitado' => null])) {
    $lastMenu = $controllerMenu->buscar([]);
    $lastMenu = $lastMenu[count($lastMenu) - 1];
    if ($controllerMenuRol->alta(['idRol' => $datos['idRol'], 'idMenu' => $lastMenu->getIdMenu()])) {
        echo json_encode(array('success' => 1));
        exit;
    }
}
echo json_encode(array('success' => 0));
