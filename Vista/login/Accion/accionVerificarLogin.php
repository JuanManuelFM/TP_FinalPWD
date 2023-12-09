<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$datos['usPass'] = md5($datos["usPass"]); //Encriptar en el cliente como en el registro
$controllerUsuario = new c_usuario();
$objUsuario = $controllerUsuario->buscar(['usNombre' => $datos['usNombre']])[0];
$objSession = new c_session();
// $usuario = $controllerUsuario->buscar(["usNombre" => $datos["usNombre"]]);
$estadoUsuario= $objUsuario->getUsDeshabilitado();
if(is_null($estadoUsuario) || $estadoUsuario == "0000-00-00 00:00:00"){
    if($objSession->validar($datos)) {
        echo json_encode(['success' => 1, 'message' => 'Ha iniciado sesión correctamente']);
        exit;
    } else {
        echo json_encode(['success' => 0, 'message' => 'Los datos ingresados no coinciden con algún usuario registrado']);
        exit;
    }
} else {
    echo json_encode(['success' => 0, 'message' => 'El usuario está deshabilitado, intente más tarde']);
    exit;
}