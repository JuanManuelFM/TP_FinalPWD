<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$controllerUsuario = new c_usuario();
$controllerUsuarioRol = new c_usuarioRol();
// $objMenu = $controllerUsuario->buscar(["usNombre" => $datos["usNombre"]]); // Busca el usuario con el nombre
//Que esta haciendo??
if ($controllerUsuario->alta([...$datos, 'usDeshabilitado' => null])) {
    $lastUsuario = $controllerUsuario->buscar([]);
    $lastUsuario = $lastUsuario[count($lastUsuario) - 1];
    if ($controllerUsuarioRol->alta(['idRol' => $datos['idRol'], 'idUsuario' => $lastUsuario->getIdUsuario()])) {
        echo json_encode(array('success' => 1));
        exit;
    }
}
echo json_encode(array('success' => 0));