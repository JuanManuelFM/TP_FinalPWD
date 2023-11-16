<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$controladorUsuario = new c_usuario();
$objUsuario = new Usuario();
$objSesion = new c_session();

$arrayUsuarios = $controladorUsuario->buscar(['idUsuario' => $datos['idUsuario']])[0];

if(array_key_exists('type', $datos) && $datos['type'] == "username") {
    $datos['usPass'] = $arrayUsuarios->getUsPass();
} else {
    // echo "passVieja: " . md5($datos['usPassVieja']) . " <br> passUsuario: " . $arrayUsuarios->getUsPass();
    //Verificamos que la contraseña vieja sea igual a la actual del usuario
    if(md5($datos['usPassVieja']) != $arrayUsuarios->getUsPass()) {
        //Si no son iguales retornamos error
        echo json_encode(['success' => 0, 'message' => 'La contraseña anterior no es correcta']);
        exit;
    }

    //Verificamos que ambas contraseñas sean iguales
    if($datos['usPassNueva'] != $datos['usPassRep']) {
        echo json_encode(['success' => 0, 'message' => 'Las contraseñas no coinciden']);
        exit;
    }

    //Verificamos que la nueva contraseña no sea igual a la que ya tiene el usuario en la BD
    if($datos['usPassNueva'] == $arrayUsuarios->getUsPass()) {
        echo json_encode(['success' => 0, 'message' => 'La nueva contraseña no puede ser igual a la anterior']);
        exit;
    }
    $datos['usPass'] = md5($datos['usPassNueva']);
    $datos['usMail'] = $arrayUsuarios->getUsMail();
    $datos['usNombre'] = $arrayUsuarios->getUsNombre();
}

$datos['usDeshabilitado'] = $arrayUsuarios->getUsDeshabilitado();
    
    if ($controladorUsuario->modificacion(['idUsuario' => $datos['idUsuario'], 'usNombre' => $datos['usNombre'], 'usPass' => $datos['usPass'], 'usMail' => $datos['usMail'], 'usDeshabilitado' => $datos['usDeshabilitado']])) {
        $objSesion->setUsNombre($datos['usNombre']);
        $objSesion->setUsPass($datos['usPass']);
        echo json_encode(array('success'=>1));
    } else {
        echo json_encode(array('success'=>0, 'message' => 'Ocurrió un error durante la modificación de la contraseña'));
    }
?>